<?php

namespace Drupal\Tests\password_policy_character_types\Unit;

use Drupal\Tests\UnitTestCase;

/**
 * Tests the character types constraint.
 *
 * @group password_policy_character_types
 */
class CharacterTypesTest extends UnitTestCase {

  /**
   * Tests the character types.
   *
   * @dataProvider characterTypesDataProvider
   */
  public function testCharacterTypes($types, $password, $result) {
    $character_types = $this->getMockBuilder('Drupal\password_policy_character_types\Plugin\PasswordConstraint\CharacterTypes')
      ->disableOriginalConstructor()
      ->setMethods(['getConfiguration', 't'])
      ->getMock();
    $character_types
      ->method('getConfiguration')
      ->willReturn(['character_types' => $types]);
    $this->assertEquals($character_types->validate($password, NULL)->isValid(), $result);
  }

  /**
   * Provides data for the testCharacterTypes method.
   */
  public function characterTypesDataProvider() {
    return [
      // Passing conditions.
      [
        3,
        'Password1',
        TRUE,
      ],
      [
        4,
        'Password1!',
        TRUE,
      ],
      [
        2,
        'Password',
        TRUE,
      ],
      // Failing conditions.
      [
        2,
        'password',
        FALSE,
      ],
      [
        3,
        'Password',
        FALSE,
      ],
      [
        4,
        'Password1',
        FALSE,
      ],
      [
        5,
        'Password1!',
        FALSE,
      ],
      // Unusual inputs.
      [
        3,
        '',
        FALSE,
      ],
      [
        -1,
        'Password!@#',
        FALSE,
      ],
      [
        10,
        'PaSwOrD!@#123',
        FALSE,
      ],
    ];
  }

}
