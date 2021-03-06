<?php //[STAMP] ac80a96528ceea7b5cddd6dab22ac128

// This class was automatically generated by build task
// You should not change it manually as it will be overwritten on next build
// @codingStandardsIgnoreFile


use Codeception\Module\Asserts;
use Codeception\Module\UnitHelper;
use Codeception\Module\Db;
use Codeception\Module\MongoDb;

/**
 * Inherited Methods
 * @method void wantToTest($text)
 * @method void wantTo($text)
 * @method void execute($callable)
 * @method void expectTo($prediction)
 * @method void expect($prediction)
 * @method void amGoingTo($argumentation)
 * @method void am($role)
 * @method void lookForwardTo($achieveValue)
 * @method void comment($description)
 * @method void haveFriend($name, $actorClass = null)
*/
class UnitTester extends \Codeception\Actor
{
    /**
     * [!] Method is generated. Documentation taken from corresponding module.
     *
     * Checks that two variables are equal.
     *
     * @param        $expected
     * @param        $actual
     * @param string $message
     *
     * @return mixed
     * @see \Codeception\Module\Asserts::assertEquals()
     */
    public function assertEquals($expected, $actual, $message = null)
    {
        return $this->scenario->runStep(new \Codeception\Step\Action('assertEquals', func_get_args()));
    }

    /**
     * [!] Method is generated. Documentation taken from corresponding module.
     *
     * Checks that two variables are not equal
     *
     * @param        $expected
     * @param        $actual
     * @param string $message
     * @see \Codeception\Module\Asserts::assertNotEquals()
     */
    public function assertNotEquals($expected, $actual, $message = null)
    {
        return $this->scenario->runStep(new \Codeception\Step\Action('assertNotEquals', func_get_args()));
    }

    /**
     * [!] Method is generated. Documentation taken from corresponding module.
     *
     * Checks that expected is greater than actual
     *
     * @param        $expected
     * @param        $actual
     * @param string $message
     * @see \Codeception\Module\Asserts::assertGreaterThan()
     */
    public function assertGreaterThan($expected, $actual, $message = null)
    {
        return $this->scenario->runStep(new \Codeception\Step\Action('assertGreaterThan', func_get_args()));
    }

    /**
     * [!] Method is generated. Documentation taken from corresponding module.
     *
     * @deprecated
     * @see \Codeception\Module\Asserts::assertGreaterThen()
     */
    public function assertGreaterThen($expected, $actual, $message = null)
    {
        return $this->scenario->runStep(new \Codeception\Step\Action('assertGreaterThen', func_get_args()));
    }

    /**
     * [!] Method is generated. Documentation taken from corresponding module.
     *
     * Checks that expected is greater or equal than actual
     *
     * @param        $expected
     * @param        $actual
     * @param string $message
     * @see \Codeception\Module\Asserts::assertGreaterThanOrEqual()
     */
    public function assertGreaterThanOrEqual($expected, $actual, $message = null)
    {
        return $this->scenario->runStep(new \Codeception\Step\Action('assertGreaterThanOrEqual', func_get_args()));
    }

    /**
     * [!] Method is generated. Documentation taken from corresponding module.
     *
     * @deprecated
     * @see \Codeception\Module\Asserts::assertGreaterThenOrEqual()
     */
    public function assertGreaterThenOrEqual($expected, $actual, $message = null)
    {
        return $this->scenario->runStep(new \Codeception\Step\Action('assertGreaterThenOrEqual', func_get_args()));
    }

    /**
     * [!] Method is generated. Documentation taken from corresponding module.
     *
     * Checks that expected is less than actual
     *
     * @param        $expected
     * @param        $actual
     * @param string $message
     * @see \Codeception\Module\Asserts::assertLessThan()
     */
    public function assertLessThan($expected, $actual, $message = null)
    {
        return $this->scenario->runStep(new \Codeception\Step\Action('assertLessThan', func_get_args()));
    }

    /**
     * [!] Method is generated. Documentation taken from corresponding module.
     *
     * Checks that expected is less or equal than actual
     *
     * @param        $expected
     * @param        $actual
     * @param string $message
     * @see \Codeception\Module\Asserts::assertLessThanOrEqual()
     */
    public function assertLessThanOrEqual($expected, $actual, $message = null)
    {
        return $this->scenario->runStep(new \Codeception\Step\Action('assertLessThanOrEqual', func_get_args()));
    }

    /**
     * [!] Method is generated. Documentation taken from corresponding module.
     *
     * Checks that haystack contains needle
     *
     * @param        $needle
     * @param        $haystack
     * @param string $message
     * @see \Codeception\Module\Asserts::assertContains()
     */
    public function assertContains($needle, $haystack, $message = null)
    {
        return $this->scenario->runStep(new \Codeception\Step\Action('assertContains', func_get_args()));
    }

    /**
     * [!] Method is generated. Documentation taken from corresponding module.
     *
     * Checks that haystack doesn't contain needle.
     *
     * @param        $needle
     * @param        $haystack
     * @param string $message
     * @see \Codeception\Module\Asserts::assertNotContains()
     */
    public function assertNotContains($needle, $haystack, $message = null)
    {
        return $this->scenario->runStep(new \Codeception\Step\Action('assertNotContains', func_get_args()));
    }

    /**
     * [!] Method is generated. Documentation taken from corresponding module.
     *
     * Checks that variable is empty.
     *
     * @param        $actual
     * @param string $message
     * @see \Codeception\Module\Asserts::assertEmpty()
     */
    public function assertEmpty($actual, $message = null)
    {
        return $this->scenario->runStep(new \Codeception\Step\Action('assertEmpty', func_get_args()));
    }

    /**
     * [!] Method is generated. Documentation taken from corresponding module.
     *
     * Checks that variable is not empty.
     *
     * @param        $actual
     * @param string $message
     * @see \Codeception\Module\Asserts::assertNotEmpty()
     */
    public function assertNotEmpty($actual, $message = null)
    {
        return $this->scenario->runStep(new \Codeception\Step\Action('assertNotEmpty', func_get_args()));
    }

    /**
     * [!] Method is generated. Documentation taken from corresponding module.
     *
     * Checks that variable is NULL
     *
     * @param        $actual
     * @param string $message
     * @see \Codeception\Module\Asserts::assertNull()
     */
    public function assertNull($actual, $message = null)
    {
        return $this->scenario->runStep(new \Codeception\Step\Action('assertNull', func_get_args()));
    }

    /**
     * [!] Method is generated. Documentation taken from corresponding module.
     *
     * Checks that variable is not NULL
     *
     * @param        $actual
     * @param string $message
     * @see \Codeception\Module\Asserts::assertNotNull()
     */
    public function assertNotNull($actual, $message = null)
    {
        return $this->scenario->runStep(new \Codeception\Step\Action('assertNotNull', func_get_args()));
    }

    /**
     * [!] Method is generated. Documentation taken from corresponding module.
     *
     * Checks that condition is positive.
     *
     * @param        $condition
     * @param string $message
     * @see \Codeception\Module\Asserts::assertTrue()
     */
    public function assertTrue($condition, $message = null)
    {
        return $this->scenario->runStep(new \Codeception\Step\Action('assertTrue', func_get_args()));
    }

    /**
     * [!] Method is generated. Documentation taken from corresponding module.
     *
     * Checks that condition is negative.
     *
     * @param        $condition
     * @param string $message
     * @see \Codeception\Module\Asserts::assertFalse()
     */
    public function assertFalse($condition, $message = null)
    {
        return $this->scenario->runStep(new \Codeception\Step\Action('assertFalse', func_get_args()));
    }

    /**
     * [!] Method is generated. Documentation taken from corresponding module.
     *
     * Fails the test with message.
     *
     * @param $message
     * @see \Codeception\Module\Asserts::fail()
     */
    public function fail($message)
    {
        return $this->scenario->runStep(new \Codeception\Step\Action('fail', func_get_args()));
    }

    /**
     * [!] Method is generated. Documentation taken from corresponding module.
     *
     * @param string $table
     * @param array  $filter
     * @see \Codeception\Module\UnitHelper::dropFromDB()
     */
    public function dropFromDB($table, $filter = null)
    {
        return $this->scenario->runStep(new \Codeception\Step\Action('dropFromDB', func_get_args()));
    }

    /**
     * [!] Method is generated. Documentation taken from corresponding module.
     *
     * Inserts SQL record into database. This record will be erased after the test.
     *
     * ``` php
     * <?php
     * $I->haveInDatabase('users', array('name' => 'miles', 'email' => 'miles@davis.com'));
     * ?>
     * ```
     *
     * @param $table
     * @param  array   $data
     * @return integer $id
     * @see \Codeception\Module\Db::haveInDatabase()
     */
    public function haveInDatabase($table, $data)
    {
        return $this->scenario->runStep(new \Codeception\Step\Action('haveInDatabase', func_get_args()));
    }

    /**
     * [!] Method is generated. Documentation taken from corresponding module.
     *
     * Checks if a row with given column values exists.
     * Provide table name and column values.
     *
     * Example:
     *
     * ``` php
     * <?php
     * $I->seeInDatabase('users', array('name' => 'Davert', 'email' => 'davert@mail.com'));
     *
     * ```
     * Will generate:
     *
     * ``` sql
     * SELECT COUNT(*) FROM `users` WHERE `name` = 'Davert' AND `email` = 'davert@mail.com'
     * ```
     * Fails if no such user found.
     *
     * @param       $table
     * @param array $criteria
     *                        Conditional Assertion: Test won't be stopped on fail
     * @see \Codeception\Module\Db::seeInDatabase()
     */
    public function canSeeInDatabase($table, $criteria = null)
    {
        return $this->scenario->runStep(new \Codeception\Step\ConditionalAssertion('seeInDatabase', func_get_args()));
    }
    /**
     * [!] Method is generated. Documentation taken from corresponding module.
     *
     * Checks if a row with given column values exists.
     * Provide table name and column values.
     *
     * Example:
     *
     * ``` php
     * <?php
     * $I->seeInDatabase('users', array('name' => 'Davert', 'email' => 'davert@mail.com'));
     *
     * ```
     * Will generate:
     *
     * ``` sql
     * SELECT COUNT(*) FROM `users` WHERE `name` = 'Davert' AND `email` = 'davert@mail.com'
     * ```
     * Fails if no such user found.
     *
     * @param       $table
     * @param array $criteria
     * @see \Codeception\Module\Db::seeInDatabase()
     */
    public function seeInDatabase($table, $criteria = null)
    {
        return $this->scenario->runStep(new \Codeception\Step\Assertion('seeInDatabase', func_get_args()));
    }

    /**
     * [!] Method is generated. Documentation taken from corresponding module.
     *
     * Effect is opposite to ->seeInDatabase
     *
     * Checks if there is no record with such column values in database.
     * Provide table name and column values.
     *
     * Example:
     *
     * ``` php
     * <?php
     * $I->dontSeeInDatabase('users', array('name' => 'Davert', 'email' => 'davert@mail.com'));
     *
     * ```
     * Will generate:
     *
     * ``` sql
     * SELECT COUNT(*) FROM `users` WHERE `name` = 'Davert' AND `email` = 'davert@mail.com'
     * ```
     * Fails if such user was found.
     *
     * @param       $table
     * @param array $criteria
     *                        Conditional Assertion: Test won't be stopped on fail
     * @see \Codeception\Module\Db::dontSeeInDatabase()
     */
    public function cantSeeInDatabase($table, $criteria = null)
    {
        return $this->scenario->runStep(new \Codeception\Step\ConditionalAssertion('dontSeeInDatabase', func_get_args()));
    }
    /**
     * [!] Method is generated. Documentation taken from corresponding module.
     *
     * Effect is opposite to ->seeInDatabase
     *
     * Checks if there is no record with such column values in database.
     * Provide table name and column values.
     *
     * Example:
     *
     * ``` php
     * <?php
     * $I->dontSeeInDatabase('users', array('name' => 'Davert', 'email' => 'davert@mail.com'));
     *
     * ```
     * Will generate:
     *
     * ``` sql
     * SELECT COUNT(*) FROM `users` WHERE `name` = 'Davert' AND `email` = 'davert@mail.com'
     * ```
     * Fails if such user was found.
     *
     * @param       $table
     * @param array $criteria
     * @see \Codeception\Module\Db::dontSeeInDatabase()
     */
    public function dontSeeInDatabase($table, $criteria = null)
    {
        return $this->scenario->runStep(new \Codeception\Step\Assertion('dontSeeInDatabase', func_get_args()));
    }

    /**
     * [!] Method is generated. Documentation taken from corresponding module.
     *
     * Fetches a single column value from a database.
     * Provide table name, desired column and criteria.
     *
     * Example:
     *
     * ``` php
     * <?php
     * $mail = $I->grabFromDatabase('users', 'email', array('name' => 'Davert'));
     *
     * ```
     *
     * @version 1.1
     *
     * @param       $table
     * @param       $column
     * @param array $criteria
     *
     * @return mixed
     * @see \Codeception\Module\Db::grabFromDatabase()
     */
    public function grabFromDatabase($table, $column, $criteria = null)
    {
        return $this->scenario->runStep(new \Codeception\Step\Action('grabFromDatabase', func_get_args()));
    }

    /**
     * [!] Method is generated. Documentation taken from corresponding module.
     *
     * Inserts data into collection
     *
     * ``` php
     * $I->haveInCollection('users', array('name' => 'John', 'email' => 'john@coltrane.com'));
     * $user_id = $I->haveInCollection('users', array('email' => 'john@coltrane.com'));
     * ```
     *
     * @param $collection
     * @param array $data
     * @see \Codeception\Module\MongoDb::haveInCollection()
     */
    public function haveInCollection($collection, $data)
    {
        return $this->scenario->runStep(new \Codeception\Step\Action('haveInCollection', func_get_args()));
    }

    /**
     * [!] Method is generated. Documentation taken from corresponding module.
     *
     * Checks if collection contains an item.
     *
     * ``` php
     * <?php
     * $I->seeInCollection('users', array('name' => 'miles'));
     * ```
     *
     * @param $collection
     * @param array $criteria
     *                        Conditional Assertion: Test won't be stopped on fail
     * @see \Codeception\Module\MongoDb::seeInCollection()
     */
    public function canSeeInCollection($collection, $criteria = null)
    {
        return $this->scenario->runStep(new \Codeception\Step\ConditionalAssertion('seeInCollection', func_get_args()));
    }
    /**
     * [!] Method is generated. Documentation taken from corresponding module.
     *
     * Checks if collection contains an item.
     *
     * ``` php
     * <?php
     * $I->seeInCollection('users', array('name' => 'miles'));
     * ```
     *
     * @param $collection
     * @param array $criteria
     * @see \Codeception\Module\MongoDb::seeInCollection()
     */
    public function seeInCollection($collection, $criteria = null)
    {
        return $this->scenario->runStep(new \Codeception\Step\Assertion('seeInCollection', func_get_args()));
    }

    /**
     * [!] Method is generated. Documentation taken from corresponding module.
     *
     * Checks if collection doesn't contain an item.
     *
     * ``` php
     * <?php
     * $I->dontSeeInCollection('users', array('name' => 'miles'));
     * ```
     *
     * @param $collection
     * @param array $criteria
     *                        Conditional Assertion: Test won't be stopped on fail
     * @see \Codeception\Module\MongoDb::dontSeeInCollection()
     */
    public function cantSeeInCollection($collection, $criteria = null)
    {
        return $this->scenario->runStep(new \Codeception\Step\ConditionalAssertion('dontSeeInCollection', func_get_args()));
    }
    /**
     * [!] Method is generated. Documentation taken from corresponding module.
     *
     * Checks if collection doesn't contain an item.
     *
     * ``` php
     * <?php
     * $I->dontSeeInCollection('users', array('name' => 'miles'));
     * ```
     *
     * @param $collection
     * @param array $criteria
     * @see \Codeception\Module\MongoDb::dontSeeInCollection()
     */
    public function dontSeeInCollection($collection, $criteria = null)
    {
        return $this->scenario->runStep(new \Codeception\Step\Assertion('dontSeeInCollection', func_get_args()));
    }

    /**
     * [!] Method is generated. Documentation taken from corresponding module.
     *
     * Grabs a data from collection
     *
     * ``` php
     * <?php
     * $cursor = $I->grabFromCollection('users', array('name' => 'miles'));
     * ```
     *
     * @param $collection
     * @param  array        $criteria
     * @return \MongoCursor
     * @see \Codeception\Module\MongoDb::grabFromCollection()
     */
    public function grabFromCollection($collection, $criteria = null)
    {
        return $this->scenario->runStep(new \Codeception\Step\Action('grabFromCollection', func_get_args()));
    }
}
