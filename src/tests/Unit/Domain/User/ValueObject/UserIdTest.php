<?php declare(strict_types=1);

namespace Tests\Unit\Domain\User\ValueObject;

use PHPUnit\Framework\TestCase;
use Package\Domain\User\ValueObject\UserId;
use Package\Domain\User\Exceptions\UserArgumentException;
use Package\Domain\User\Exceptions\UserArgumentNullException;

class UserIdTest extends TestCase {

  /**
   * @test
   */
  public function it_should_return_valid_user_id()
  {
    $tests = [1, 100, 999999];
    foreach ($tests as $test) {
      $instance = new UserId($test);
      $this->assertInstanceOf(UserId::class, $instance);
      $this->assertSame($test, $instance->getValue());
    }
  }

  /**
   * @test
   */
  public function it_should_return_failure_argument_exception()
  {
    $this->expectException(UserArgumentException::class);

    $tests = [-1, 1000000];
    foreach ($tests as $test) {
      $instance = new UserId($test);
      $this->assertNull($instance->getValue());
    }
  }

  /**
   * @test
   */
  public function it_should_return_failure_argument_null_exception()
  {
    $this->expectException(UserArgumentNullException::class);

    $tests = ['', null];
    foreach ($tests as $test) {
      $instance = new UserId($test);
    }
  }

}