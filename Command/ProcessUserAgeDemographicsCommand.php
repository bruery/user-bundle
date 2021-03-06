<?php
/**
 * This file is part of the Bruery Platform.
 *
 * (c) Viktore Zara <viktore.zara@gmail.com>
 * (c) Mell Zamora <mellzamora@outlook.com>
 *
 * Copyright (c) 2016. For the full copyright and license information, please view the LICENSE  file that was distributed with this source code.
 */

namespace Bruery\UserBundle\Command;

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputDefinition;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class ProcessUserAgeDemographicsCommand extends BaseCommand
{
    /**
     * {@inheritdoc}
     */
    public function configure()
    {
            $this->setName('bruery:user:process-user-age-demographics')
                ->setDefinition(
                    new InputDefinition(array(
                        new InputArgument('context', InputArgument::REQUIRED),
                    ))
                );
            $this->addOption('no-confirmation', null, InputOption::VALUE_OPTIONAL, 'Ask confirmation before processing age demographics', false);
            $this->setDescription('Process user age demographics');

            $this->setHelp(<<<EOT
The <info>bruery:user:process-user-age-demographics</info> command to process user age demographics.
EOT
            );
    }

    /**
     * {@inheritdoc}
     */
    public function execute(InputInterface $input, OutputInterface $output)
    {
        if ($this->getContainer()->getParameter('bruery.user.user_age_demographics.enabled')) {
            $dialog = $this->getHelperSet()->get('dialog');

            $context = $input->getArgument('context');

            if ($input->getOption('no-confirmation') || $dialog->askConfirmation($output, 'Confirm user age demographics processing?', true)) {
                $output->writeln(array(
                    '',
                    '<info>Start processing user age demographics!</info>',
                    ''));
                $users = $this->getUserManager()->findAll();

                if (count($users) > 0) {
                    foreach ($users as $user) {
                        if ($user->getDateOfBirth()) {
                            $age = $this->getAge($user->getDateOfBirth());
                            if ($ageBracket = $this->getUserHelper()->getAgeBracket($age, $context)) {
                                if (!$ageDemographics = $this->getUserAgeDemographicsManager()->findOneBy(array('user'=>$user))) {
                                    $this->create($user, $ageBracket);
                                } else {
                                    $this->update($ageDemographics, $ageBracket);
                                }
                            }
                        }
                    }
                } else {
                    $output->writeln('<error>No User found!</error>');
                }
            } else {
                $output->writeln('<error>Age demographics processing cancelled !</error>');
            }
        } else {
            $output->writeln('<error>Age demographics not available !</error>');
        }
    }

    protected function create($user, $collection)
    {
        $ageDemographics = $this->getUserAgeDemographicsManager()->create();
        $ageDemographics->setUser($user);
        $ageDemographics->setCollection($collection);
        $this->getUserAgeDemographicsManager()->save($ageDemographics);
    }

    protected function update($ageDemographics, $collection)
    {
        $ageDemographics->setCollection($collection);
        $this->getUserAgeDemographicsManager()->save($ageDemographics);
    }

    protected function getAge($bDate)
    {
        return date_diff($bDate, date_create('today'))->y;
    }

    public function getUserHelper()
    {
        return $this->getContainer()->get('bruery.user.user_helper');
    }

    public function getUserAgeDemographicsManager()
    {
        return $this->getContainer()->get('bruery.user.manager.user_age_demographics');
    }
}
