<?php

namespace EasyAdminAzFields\Form;

use EasyCorp\Bundle\EasyAdminBundle\Contracts\Field\FieldInterface;
use EasyCorp\Bundle\EasyAdminBundle\Field\FieldTrait;
use Symfony\Contracts\Translation\TranslatableInterface;

class RichEditorField implements FieldInterface
{
    use FieldTrait;

    public static function new(string $propertyName, TranslatableInterface|string|bool|null $label = null): FieldInterface
    {
        return (new self())
            ->setProperty($propertyName)
            ->setLabel($label)
            ->setFormType(RichEditorType::class)
            ->addJsFiles('/bundles/easyadminazfields/js/rich_editor_field.js')
            ->addJsFiles('/bundles/easyadminazfields/vendor/tinymce/tinymce.min.js')
            ->addFormTheme('@EasyAdminAzFields/rich_editor_field.html.twig')
            ->setTemplatePath('@EasyAdminAzFields/rich_editor_field.html.twig');
    }

    public function setAllowScriptUrls(bool $allowScriptUrls): self
    {
        return $this->setFormTypeOption(RichEditorType::OPTION_ALLOW_SCRIPT_URLS, $allowScriptUrls);
    }

    public function setRelativeUrls(bool $allowRelativeUrls): self
    {
        return $this->setFormTypeOption(RichEditorType::OPTION_RELATIVE_URLS, $allowRelativeUrls);
    }

    public function setLanguage(string $language): self
    {
        return $this->setFormTypeOption(RichEditorType::OPTION_LANGUAGE, $language);
    }

    public function setSpellcheckerLanguages(array $spellcheckerLanguages): self
    {
        return $this->setFormTypeOption(RichEditorType::OPTION_SPELLCHECKER_LANGUAGES, $spellcheckerLanguages);
    }

    public function setHeight(int $height): self
    {
        return $this->setFormTypeOption(RichEditorType::OPTION_HEIGHT, $height);
    }

    public function setEntityEncoding(string $entityEncoding): self
    {
        return $this->setFormTypeOption(RichEditorType::OPTION_ENTITY_ENCODING, $entityEncoding);
    }

    public function setBrowserSpellcheck(bool $enableBrowserSpellcheck): self
    {
        return $this->setFormTypeOption(RichEditorType::OPTION_BROWSER_SPELLCHECK, $enableBrowserSpellcheck);
    }

    public function setPlugins(array $plugins): self
    {
        return $this->setFormTypeOption(RichEditorType::OPTION_PLUGINS, $plugins);
    }

    public function setToolbar(array|string $toolbar): self
    {
        return $this->setFormTypeOption(RichEditorType::OPTION_TOOLBAR, $toolbar);
    }

    public function setPasteAsText(bool $canPasteAsText): self
    {
        return $this->setFormTypeOption(RichEditorType::OPTION_PASTE_AS_TEXT, $canPasteAsText);
    }
}
