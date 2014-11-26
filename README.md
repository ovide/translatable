translatable
============

Manage translatable fields with Phalcon models

## Usage example

You have a database table `MyModel` with columns `id`, `value`, `timestamp` and `description`;
but `description` must be a translatable field.

You can add a`Translation` table as
```sql
CREATE TABLE `translation` (
  `table` varchar(255) NOT NULL,
  `field` varchar(255) NOT NULL,
  `row` varchar(255) NOT NULL,
  `lang` char(2) NOT NULL,
  `text` text NOT NULL,
  PRIMARY KEY (`table`,`field`,`row`,`lang`)
)
```

```php
/**
 * Your translatable model
 * @property string $description
 */
class MyModel extends \Ovide\Lib\Translate\Model
{
    public $id;
    public $value;
    public $timestamp;
    protected $_translatable = ['description'];
}

/**
 * This is a default basic abstract model, but you can add yours
 */
class Translation extends Ovide\Lib\Translate\Adapter\Model\AbstractModel{}


$di = new \Phalcon\DI\FactoryDefault();
$di->setShared('db', function () {
    return new \Phalcon\Db\Adapter\Pdo\Mysql([/* my config */]);
});

/**
 *             HERE WE SET THE TRANSLATOR
 */
$di->setShared('translator', function() {
    $service = new \Ovide\Lib\Translate\Service();
    //All translatable models from 'db'
    //will use 'Translation' to manage the translations
    $service->attachAdapter(
        'db',
        Ovide\Lib\Translate\Adapter\Model\Manager::class,
        ['backendModel' => 'Translation']
    );
});
```

Now you can use
