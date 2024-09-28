<?php

declare(strict_types=1);

namespace Answear\EcontBundle\Tests\Unit;

use Answear\EcontBundle\ConfigProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

class ConfigProviderTest extends TestCase
{
    #[Test]
    public function gettersAreValid(): void
    {
        $configuration = new ConfigProvider('test', 'Qwerty123!');

        $this->assertSame('http://ee.econt.com/', ConfigProvider::URL);
        $this->assertSame('/services/Nomenclatures/', ConfigProvider::SERVICE_URI);
        $this->assertSame(
            [
                'base_uri' => 'http://ee.econt.com/',
                'auth' => [$configuration->user, $configuration->password],
            ],
            $configuration->getRequestHeaders()
        );
    }
}
