<?php

declare(strict_types=1);

namespace ParaTest\Tests;

use PHPUnit\Framework\Assert;
use Symfony\Component\Filesystem\Filesystem;

use function getenv;
use function glob;

use const DIRECTORY_SEPARATOR;

final class TmpDirCreator
{
    public function create(): string
    {
        $tmpDir = TEST_DIR . DIRECTORY_SEPARATOR . 'tmp' . DIRECTORY_SEPARATOR . 'token_' . (string) getenv('TEST_TOKEN');

        $glob = glob($tmpDir . DIRECTORY_SEPARATOR . '*');
        Assert::assertNotFalse($glob);

        (new Filesystem())->remove($glob);
        (new Filesystem())->mkdir($tmpDir);

        return $tmpDir;
    }
}
