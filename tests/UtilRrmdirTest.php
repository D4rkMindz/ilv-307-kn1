<?php

namespace App\Test;

use org\bovigo\vfs\vfsStream;
use org\bovigo\vfs\visitor\vfsStreamStructureVisitor;
use PHPUnit\Framework\TestCase;
use org\bovigo\vfs\vfsStreamWrapper;

class UtilRrmdirTest extends TestCase
{
    /**
     * Set up Virtual File System (vfs).
     */
    public function setUp()
    {
        vfsStreamWrapper::register();
        $structure = [
            "should-stay-directory" => [],
            "directory" => [
                "sub-directory1" => [
                    "sub-sub-directory1" => [],
                    "sub-sub-directory2" => [],
                    "sub-sub-directory3" => [],
                    "sub-sub-directory4" => []
                ],
                "sub-directory2" => [
                    "sub-sub-directory1" => [],
                    "sub-sub-directory2" => [],
                    "sub-sub-directory3" => [],
                    "sub-sub-directory4" => []
                ],
                "sub-directory3" => [
                    "sub-sub-directory1" => [],
                    "sub-sub-directory2" => [],
                    "sub-sub-directory3" => [],
                    "sub-sub-directory4" => []
                ],
                "sub-directory4" => [
                    "sub-sub-directory1" => [],
                    "sub-sub-directory2" => [],
                    "sub-sub-directory3" => [],
                    "sub-sub-directory4" => []
                ]
            ]
        ];
        $vfs = vfsStream::setup('root');
        vfsStream::create($structure, $vfs);
    }

    /**
     * ServicesContainerTest rrmdir.
     *
     * @covers ::rrmdir
     */
    public function testRrmdir()
    {
        $tree = vfsStream::inspect(new vfsStreamStructureVisitor())->getStructure();
        $treeRoot = [
            "root" => [
                "should-stay-directory" => [],
                "directory" => [
                    "sub-directory1" => [
                        "sub-sub-directory1" => [],
                        "sub-sub-directory2" => [],
                        "sub-sub-directory3" => [],
                        "sub-sub-directory4" => []
                    ],
                    "sub-directory2" => [
                        "sub-sub-directory1" => [],
                        "sub-sub-directory2" => [],
                        "sub-sub-directory3" => [],
                        "sub-sub-directory4" => []
                    ],
                    "sub-directory3" => [
                        "sub-sub-directory1" => [],
                        "sub-sub-directory2" => [],
                        "sub-sub-directory3" => [],
                        "sub-sub-directory4" => []
                    ],
                    "sub-directory4" => [
                        "sub-sub-directory1" => [],
                        "sub-sub-directory2" => [],
                        "sub-sub-directory3" => [],
                        "sub-sub-directory4" => []
                    ]
                ]
            ]
        ];
        $this->assertSame($tree, $treeRoot);

        $children = vfsStreamWrapper::getRoot()->hasChildren();
        $this->assertTrue($children);

        $url = vfsStream::url("root/directory");
        rrmdir($url);

        $childrenAfter = vfsStreamWrapper::getRoot()->hasChild("directory");
        $this->assertFalse($childrenAfter);

        $treeAfter = vfsStream::inspect(new vfsStreamStructureVisitor())->getStructure();
        $treeRootAfter = [
            "root" => [
                "should-stay-directory" => []
            ]
        ];
        $this->assertSame($treeRootAfter, $treeAfter);
    }
}
