<?php

namespace App\Test;

use PHPUnit\Framework\TestCase;
use MatthiasMullie\Minify;

/**
 * Class UtilAssetTest
 */
class UtilAssetTest extends TestCase
{
    protected $emptyJsFile = __DIR__ . "/assets/empty.js";

    protected $emptyCssFile= __DIR__ . "/assets/empty.css";

    protected $validJsPath = __DIR__ . "/assets/test.js";

    protected $validCssPath = __DIR__ . "/assets/test.css";

    protected $invalidJsPath = __DIR__ . "/assets/test-fail.js";

    protected $invalidCssPath = __DIR__ . "/assets/test-fail.css";

    /**
     * Function asset()
     *
     * ServicesContainerTest JavaScript not empty file.
     *
     * @covers ::asset
     */
    public function testAssetJsRegular()
    {
        $this->clearCache();

        $config = config();
        $config->set("assets.cachePath", __DIR__ . '/../tmp/cache/');
        $config->set("assets.minimize", false);

        $actual = asset($this->validJsPath);
        $expected = "<script type='text/javascript'>" . file_get_contents($this->validJsPath) . "</script>";
        $this->assertSame($expected, $actual);
    }

    /**
     * Function asset()
     *
     * ServicesContainerTest CSS not empty file.
     *
     * @covers ::asset
     */
    public function testAssetCssRegular()
    {
        $this->clearCache();

        $config = config();
        $config->set("assets.cachePath", __DIR__ . '/../tmp/cache/');
        $config->set("assets.minimize", false);

        $actual = asset($this->validCssPath);
        $expected = "<style>" . file_get_contents($this->validCssPath) . "</style>";
        $this->assertSame($expected, $actual);
    }

    /**
     * Function asset()
     *
     * ServicesContainerTest JavaScript empty file.
     *
     * @covers ::asset
     */
    public function testAssetEmptyJsFile()
    {
        $this->clearCache();

        $config = config();
        $config->set("assets.cachePath", __DIR__ . '/../tmp/cache/');
        $config->set("assets.minimize", false);

        $actual = asset($this->emptyJsFile);
        $expected = "<script type='text/javascript'></script>";
        $this->assertSame($expected, $actual);
    }

    /**
     * Function asset()
     *
     * ServicesContainerTest CSS not empty file.
     *
     * @covers ::asset
     */
    public function testAssetEmptyCssFile()
    {
        $this->clearCache();

        $config = config();
        $config->set("assets.cachePath", __DIR__ . '/../tmp/cache/');
        $config->set("assets.minimize", false);

        $actual = asset($this->emptyCssFile);
        $expected = "<style></style>";
        $this->assertSame($actual, $expected);
    }

    /**
     * Function asset_js()
     *
     * ServicesContainerTest JavaScript not empty file with minify().
     *
     * @covers ::asset_js
     */
    public function testAssetJsMinifyTrue()
    {
        $this->clearCache();

        $config = config();
        $config->set("assets.cachePath", __DIR__ . '/../tmp/cache/');
        $config->set("assets.minimize", false);

        $actual = asset_js($this->validJsPath, true);
        $minifier = new Minify\JS($this->validJsPath);
        $expected = "<script type='text/javascript'>" . $minifier->minify() . "</script>";
        $this->assertSame($expected, $actual);
    }

    /**
     * Function asset_css()
     *
     * ServicesContainerTest CSS not empty file with minify().
     *
     * @covers ::asset_css
     */
    public function testAssetCssMinifyTrue()
    {
        $this->clearCache();

        $actual = asset_css($this->validCssPath, true);
        $minify = new Minify\CSS($this->validCssPath);
        $expected = "<style>" . $minify->minify() . "</style>";
        $this->assertSame($expected, $actual);
    }

    /**
     * Function asset_js()
     *
     * ServicesContainerTest JavaScript empty file with minify().
     *
     * @covers ::asset_js
     */
    public function testAssetJsMinifyTrueEmptyJsFile()
    {
        $this->clearCache();

        $actual = asset_js($this->invalidJsPath, true);
        $expected = "<script type='text/javascript'>" . $this->invalidJsPath . "</script>";
        $this->assertSame($expected, $actual);
    }

    /**
     * Function asset_css()
     *
     * ServicesContainerTest CSS not empty file with minify().
     *
     * @covers ::asset_css
     */
    public function testAssetCssMinifyTrueEmptyCssFile()
    {
        $this->clearCache();

        $actual = asset_css($this->invalidCssPath, true);
        $expected = "<style>" . $this->invalidCssPath . "</style>";
        $this->assertSame($expected, $actual);
    }

    /**
     * Function asset_js().
     *
     * ServiceContainerTest JS not empty file without minify()
     *
     * @covers ::asset_js
     */
    public function testAssetJsMinifyFalse()
    {
        $this->clearCache();

        $actual = asset_js($this->validJsPath, false);
        $expected = "<script type='text/javascript'>" . file_get_contents($this->validJsPath) . "</script>";
        $this->assertSame($actual, $expected);
    }

    /**
     * Function asset_js().
     *
     * ServiceContainerTest JS not empty file without minify()
     *
     * @covers ::asset_js
     */
    public function testAssetCssMinifyFalse()
    {
        $this->clearCache();

        $actual = asset_css($this->validCssPath, false);
        $expected = "<style>" . file_get_contents($this->validCssPath) . "</style>";
        $this->assertSame($actual, $expected);
    }

    /**
     * Clear cache.
     */
    public function clearCache()
    {
        $dir = __DIR__ . "/../tmp/cache/";
        if (is_dir($dir)) {
            rrmdir($dir);
        }
    }
}
