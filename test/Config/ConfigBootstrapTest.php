<?php

declare(strict_types=1);

namespace Mos\Config;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for the configuration file bootstrap.php.
 */
class ConfigBootstrapTest extends TestCase
{
    private $bootstrapFile = INSTALL_PATH . "/config/bootstrap.php";
    private $routerFile = INSTALL_PATH . "/config/router.php";

    /**
     * Require the bootstrap file.
     */
    public function testRequirebootstrapFile()
    {
        $exp = 1;
        $res = require $this->bootstrapFile;
        $this->assertEquals($exp, $res);
    }

    /**
     * Require the router file.
     */
    public function testRequireRouterFile()
    {
        $exp = 1;
        $res = require $this->routerFile;
        $this->assertEquals($exp, $res);
    }

    /**
     * Test that bootstrap sets display_errors to 1
     */
    public function testBootstrapErrorSetting()
    {
        $errorSetting = setupEnvironment();

        $this->assertEquals(1, $errorSetting);
    }
}
