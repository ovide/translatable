<?php namespace Ovide\Lib\Model;

/**
 * Extends a model to manage translations.
 *
 * You must add into the DI a model that implements
 * Igm\Model\TranslationInterface to manage the translation table.
 *
 * The table must have no translatabel columns. Those must be declared in
 * the $_translatable array so this class will find that through the interface.
 * Translations are saved/fetched after saving/fetching the main record.
 *
 * All the translatable fields are accessible by the methods getTranslation()
 * and setTranslation, or through the magic getter/setter, so you should add
 * those attributes as a comment in the class header.
 *
 * @author albert@ovide.net
 */
class Translatable extends Model
{

}
