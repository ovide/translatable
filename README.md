translatable
============

Manage translatable fields with Phalcon models

## Example

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
use \Ovide\Lib\Translate as Translate;

/**
 * Your translatable model
 * @property string $description
 */
class MyModel extends Translate\Model
{
    public $id;
    public $value;
    public $timestamp;
    protected $_translatable = ['description'];
}

/**
 * This is a default basic abstract model, but you can add yours
 */
class Translation extends Translate\Adapter\Model\AbstractModel{}


$di = new \Phalcon\DI\FactoryDefault();
$di->setShared('db', function () {
    return new \Phalcon\Db\Adapter\Pdo\Mysql([/* my config */]);
});

/**
 *             HERE WE SET THE TRANSLATOR
 */
$di->setShared('translator', function() {
    $service = new Translate\Service();
    //All translatable models from 'db'
    //will use 'Translation' to manage the translations
    $service->attachAdapter(
        'db',
        Translate\Adapter\Model\Manager::class,
        ['backendModel' => 'Translation']
    );
    //You can use a default language resolver
    Translate\Model::setLanguageResolver(function() use($di){
        //You can put anything here
        if (isset($_COOKIE['lang'])) return $_COOKIE['lang'];
        return 'en';
    });
});
```

Now you can use translatable fiels as normal properties

```php
$model = new MyModel();
$model->value = 'foo';
//Will set the text using the default language
$model->description = 'my description';
//You can change the current language
$model->setCurrentLang('es');
$model->description = 'mi descripción';
//Or use setter/getter
$model->setTranslation('description', 'la meva descipció', 'ca');
$model->save();
```

## Adapters
You can use any addapter to store translations. By now there's a Model (SQL) and Collection (Mongo) adapter. Just implement `TranslationInterface` to create your own.
```php
interface TranslationInterface
{
    public static function retrieve(Model $model, $pk, array $options = null);
    public function get($field, $language);
    public function set($field, $language, $value);
    public function persist(array $records = null);
    public function remove();
}
```
