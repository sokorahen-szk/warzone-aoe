<?php declare(strict_types=1);

namespace Tests\Unit\Domain\User\ValueObject;

use PHPUnit\Framework\TestCase;
use Package\Domain\User\ValueObject\WebSiteUrl;

class WebSiteUrlTest extends TestCase {

  public function testNewWebSiteUrl()
  {
    $expected = 'https://example.com';
    $instance = new WebSiteUrl($expected);

    $this->assertInstanceOf(WebSiteUrl::class, $instance);
    $this->assertEquals($expected, $instance->getValue());
  }

}