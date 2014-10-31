<?php

namespace FluxBB\Installer\Console;

use Symfony\Component\Console\Helper\HelperSet;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;

class UserDataProvider implements DataProviderInterface
{
    protected $input;

    protected $output;

    protected $helperSet;


    public function __construct(InputInterface $input, OutputInterface $output, HelperSet $helperSet)
    {
        $this->input = $input;
        $this->output = $output;
        $this->helperSet = $helperSet;
    }

    public function getDatabaseConfiguration()
    {
        return [
            'driver'                => 'mysql',
            'host'                  => $this->ask('Database host:'),
            'database'              => $this->ask('Database name:'),
            'username'              => $this->ask('Database user:'),
            'password'              => $this->secret('Database password:'),
            'password_confirmation' => $this->secret('Confirm database password:'),
        ];
    }

    public function getAdminUser()
    {
        return [
            'username'              => $this->ask('Admin username:'),
            'password'              => $this->secret('Admin password:'),
            'password_confirmation' => $this->secret('Confirm admin password:'),
            'email'                 => $this->ask('Admin email address:'),
        ];
    }

    public function getBoardOptions()
    {
        return [
            'board_title' => $this->ask('Board title:'),
            'board_desc'  => $this->ask('Board description:'),
        ];
    }

    protected function ask($question, $default = null)
    {
        $helper = $this->helperSet->get('question');

        $question = new Question("<question>$question</question> ", $default);

        return $helper->ask($this->input, $this->output, $question);
    }

    protected function secret($question)
    {
        $helper = $this->helperSet->get('question');

        $question = new Question("<question>$question</question> ");

        $question->setHidden(true)->setHiddenFallback(true);

        return $helper->ask($this->input, $this->output, $question);
    }
}
