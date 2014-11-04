<?php

namespace FluxBB\Installer\Console;

interface DataProviderInterface
{
    public function getDatabaseConfiguration();

    public function getAdminUser();

    public function getBoardOptions();
}
