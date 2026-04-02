<?php

namespace EasyAdminAzFields\Tests\Form;

use EasyAdminAzFields\Form\RichEditorField;
use EasyAdminAzFields\Form\RichEditorType;
use EasyCorp\Bundle\EasyAdminBundle\Contracts\Field\FieldInterface;
use PHPUnit\Framework\TestCase;

class RichEditorFieldTest extends TestCase
{
    private RichEditorField $field;

    protected function setUp(): void
    {
        $this->field = RichEditorField::new('content');
    }

    public function testNewReturnsFieldInterface(): void
    {
        $this->assertInstanceOf(FieldInterface::class, $this->field);
    }

    public function testNewSetsFormType(): void
    {
        $this->assertSame(RichEditorType::class, $this->field->getAsDto()->getFormType());
    }

    public function testNewSetsProperty(): void
    {
        $this->assertSame('content', $this->field->getAsDto()->getProperty());
    }

    public function testSetAllowScriptUrls(): void
    {
        $this->field->setAllowScriptUrls(true);

        $options = $this->field->getAsDto()->getFormTypeOptions();
        $this->assertTrue($options[RichEditorType::OPTION_ALLOW_SCRIPT_URLS]);
    }

    public function testSetRelativeUrls(): void
    {
        $this->field->setRelativeUrls(true);

        $options = $this->field->getAsDto()->getFormTypeOptions();
        $this->assertTrue($options[RichEditorType::OPTION_RELATIVE_URLS]);
    }

    public function testSetLanguage(): void
    {
        $this->field->setLanguage('pl');

        $options = $this->field->getAsDto()->getFormTypeOptions();
        $this->assertSame('pl', $options[RichEditorType::OPTION_LANGUAGE]);
    }

    public function testSetSpellcheckerLanguages(): void
    {
        $this->field->setSpellcheckerLanguages(['pl', 'en']);

        $options = $this->field->getAsDto()->getFormTypeOptions();
        $this->assertSame(['pl', 'en'], $options[RichEditorType::OPTION_SPELLCHECKER_LANGUAGES]);
    }

    public function testSetHeight(): void
    {
        $this->field->setHeight(800);

        $options = $this->field->getAsDto()->getFormTypeOptions();
        $this->assertSame(800, $options[RichEditorType::OPTION_HEIGHT]);
    }

    public function testSetEntityEncoding(): void
    {
        $this->field->setEntityEncoding('named');

        $options = $this->field->getAsDto()->getFormTypeOptions();
        $this->assertSame('named', $options[RichEditorType::OPTION_ENTITY_ENCODING]);
    }

    public function testSetBrowserSpellcheck(): void
    {
        $this->field->setBrowserSpellcheck(false);

        $options = $this->field->getAsDto()->getFormTypeOptions();
        $this->assertFalse($options[RichEditorType::OPTION_BROWSER_SPELLCHECK]);
    }

    public function testSetPlugins(): void
    {
        $plugins = ['lists', 'code'];
        $this->field->setPlugins($plugins);

        $options = $this->field->getAsDto()->getFormTypeOptions();
        $this->assertSame($plugins, $options[RichEditorType::OPTION_PLUGINS]);
    }

    public function testSetToolbarAsString(): void
    {
        $this->field->setToolbar('bold italic');

        $options = $this->field->getAsDto()->getFormTypeOptions();
        $this->assertSame('bold italic', $options[RichEditorType::OPTION_TOOLBAR]);
    }

    public function testSetToolbarAsArray(): void
    {
        $toolbar = ['bold', 'italic', 'underline'];
        $this->field->setToolbar($toolbar);

        $options = $this->field->getAsDto()->getFormTypeOptions();
        $this->assertSame($toolbar, $options[RichEditorType::OPTION_TOOLBAR]);
    }

    public function testSetPasteAsText(): void
    {
        $this->field->setPasteAsText(false);

        $options = $this->field->getAsDto()->getFormTypeOptions();
        $this->assertFalse($options[RichEditorType::OPTION_PASTE_AS_TEXT]);
    }

    public function testAllSettersReturnSelf(): void
    {
        $field = RichEditorField::new('body');

        $this->assertSame($field, $field->setAllowScriptUrls(true));
        $this->assertSame($field, $field->setRelativeUrls(true));
        $this->assertSame($field, $field->setLanguage('en'));
        $this->assertSame($field, $field->setSpellcheckerLanguages(['en']));
        $this->assertSame($field, $field->setHeight(500));
        $this->assertSame($field, $field->setEntityEncoding('raw'));
        $this->assertSame($field, $field->setBrowserSpellcheck(true));
        $this->assertSame($field, $field->setPlugins([]));
        $this->assertSame($field, $field->setToolbar('bold'));
        $this->assertSame($field, $field->setPasteAsText(true));
    }
}
