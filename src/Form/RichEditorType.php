<?php

namespace EasyAdminAzFields\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RichEditorType extends AbstractType
{
    public const string OPTION_ALLOW_SCRIPT_URLS = "allowScriptUrls";
    public const string OPTION_RELATIVE_URLS = "relativeUrls";
    public const string OPTION_LANGUAGE = "language";
    public const string OPTION_SPELLCHECKER_LANGUAGES = "spellcheckerLanguages";
    public const string OPTION_HEIGHT = "height";
    public const string OPTION_ENTITY_ENCODING = "entityEncoding";
    public const string OPTION_BROWSER_SPELLCHECK = "browserSpellcheck";
    public const string OPTION_PLUGINS = "plugins";
    public const string OPTION_TOOLBAR = "toolbar";
    public const string OPTION_PASTE_AS_TEXT = "pasteAsText";

    public function getBlockPrefix(): string
    {
        return 'rich_editor';
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'compound' => false,
            'html5' => true,
            'invalid_message' => function (Options $options, $previousValue) {
                return self::class . ' failure: ' . $previousValue;
            },
            self::OPTION_ALLOW_SCRIPT_URLS => false,
            self::OPTION_RELATIVE_URLS => false,
            self::OPTION_LANGUAGE => 'en',
            self::OPTION_SPELLCHECKER_LANGUAGES => ['en'],
            self::OPTION_HEIGHT => 500,
            self::OPTION_ENTITY_ENCODING => 'raw',
            self::OPTION_BROWSER_SPELLCHECK => true,
            self::OPTION_PLUGINS => [
                'advlist lists charmap print preview anchor',
                'searchreplace code fullscreen',
                'insertdatetime table paste code wordcount',
            ],
            self::OPTION_TOOLBAR => 'undo redo
             | styleselect 
             | bold italic forecolor backcolor insert_quote 
             | alignleft aligncenter alignright alignjustify 
             | bullist numlist outdent indent 
             | fullscreen code 
             | removeformat 
             | custom-indentation',
            self::OPTION_PASTE_AS_TEXT => true,
        ]);
    }

    public function buildView(FormView $view, FormInterface $form, array $options): void
    {
        parent::buildView($view, $form, $options);
        $view->vars[self::OPTION_ALLOW_SCRIPT_URLS] = $options[self::OPTION_ALLOW_SCRIPT_URLS];
        $view->vars[self::OPTION_RELATIVE_URLS] = $options[self::OPTION_RELATIVE_URLS];
        $view->vars[self::OPTION_LANGUAGE] = $options[self::OPTION_LANGUAGE];
        $view->vars[self::OPTION_SPELLCHECKER_LANGUAGES] = $options[self::OPTION_SPELLCHECKER_LANGUAGES];
        $view->vars[self::OPTION_HEIGHT] = $options[self::OPTION_HEIGHT];
        $view->vars[self::OPTION_ENTITY_ENCODING] = $options[self::OPTION_ENTITY_ENCODING];
        $view->vars[self::OPTION_BROWSER_SPELLCHECK] = $options[self::OPTION_BROWSER_SPELLCHECK];
        $view->vars[self::OPTION_PLUGINS] = $options[self::OPTION_PLUGINS];
        $view->vars[self::OPTION_TOOLBAR] = $options[self::OPTION_TOOLBAR];
        $view->vars[self::OPTION_PASTE_AS_TEXT] = $options[self::OPTION_PASTE_AS_TEXT];
    }

    public function getParent(): string
    {
        return TextareaType::class;
    }
}
