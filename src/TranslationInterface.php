<?php namespace Ovide\Lib\Translate;

/**
 * Defines an adapter that stores/retrieves translations for a given Model
 */
interface TranslationInterface
{
    /**
     * Gets a Translation for the model instance
     *
     * @param  \Ovide\Lib\Translate\Model $model
     * @param  array                      $pk      Field keys that identifies the source model
     * @param  array                      $options
     * @return TranslationInterface
     */
    public static function retrieve(Model $model, $pk, array $options = null);

    /**
     * Gets the model translation for a given field and language
     *
     * @param  string $field
     * @param  string $language
     * @return string
     */
    public function get($field, $language);

    /**
     * Sets the model translation for a given field and language
     *
     * @param string $field
     * @param string $language
     * @param string $value
     */
    public function set($field, $language, $value);

    /**
     * Persists the translations associated to the Model
     *
     * @param  array $records $language => [$fields, ...]
     *                        If given, just persists the values for the $languages[$fields] provided
     * @return bool
     */
    public function persist(array $records = null);

    /**
     * Removes the translation from the backend
     * @return bool
     */
    public function remove();
}
