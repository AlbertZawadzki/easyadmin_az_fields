<?php

namespace EasyAdminAzFields\Tests\Form;

use EasyAdminAzFields\Form\RichEditorType;
use PHPUnit\Framework\Attributes\AllowMockObjectsWithoutExpectations;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Test\TypeTestCase;

#[AllowMockObjectsWithoutExpectations]
class RichEditorTypeTest extends TypeTestCase
{
    public function testGetBlockPrefix(): void
    {
        $type = new RichEditorType();

        $this->assertSame('rich_editor', $type->getBlockPrefix());
    }

    public function testGetParent(): void
    {
        $type = new RichEditorType();

        $this->assertSame(TextareaType::class, $type->getParent());
    }

    public function testDefaultViewVars(): void
    {
        $view = $this->factory->create(RichEditorType::class)->createView();

        $this->assertFalse($view->vars[RichEditorType::OPTION_ALLOW_SCRIPT_URLS]);
        $this->assertFalse($view->vars[RichEditorType::OPTION_RELATIVE_URLS]);
        $this->assertSame('en', $view->vars[RichEditorType::OPTION_LANGUAGE]);
        $this->assertSame(['en'], $view->vars[RichEditorType::OPTION_SPELLCHECKER_LANGUAGES]);
        $this->assertSame(500, $view->vars[RichEditorType::OPTION_HEIGHT]);
        $this->assertSame('raw', $view->vars[RichEditorType::OPTION_ENTITY_ENCODING]);
        $this->assertTrue($view->vars[RichEditorType::OPTION_BROWSER_SPELLCHECK]);
        $this->assertTrue($view->vars[RichEditorType::OPTION_PASTE_AS_TEXT]);
        $this->assertIsArray($view->vars[RichEditorType::OPTION_PLUGINS]);
        $this->assertNotEmpty($view->vars[RichEditorType::OPTION_TOOLBAR]);
    }

    public function testCustomViewVars(): void
    {
        $view = $this->factory->create(RichEditorType::class, null, [
            RichEditorType::OPTION_LANGUAGE => 'pl',
            RichEditorType::OPTION_HEIGHT => 800,
            RichEditorType::OPTION_ALLOW_SCRIPT_URLS => true,
            RichEditorType::OPTION_RELATIVE_URLS => true,
            RichEditorType::OPTION_BROWSER_SPELLCHECK => false,
            RichEditorType::OPTION_PASTE_AS_TEXT => false,
            RichEditorType::OPTION_ENTITY_ENCODING => 'named',
            RichEditorType::OPTION_SPELLCHECKER_LANGUAGES => ['pl', 'en'],
            RichEditorType::OPTION_PLUGINS => ['lists'],
            RichEditorType::OPTION_TOOLBAR => 'bold italic',
        ])->createView();

        $this->assertSame('pl', $view->vars[RichEditorType::OPTION_LANGUAGE]);
        $this->assertSame(800, $view->vars[RichEditorType::OPTION_HEIGHT]);
        $this->assertTrue($view->vars[RichEditorType::OPTION_ALLOW_SCRIPT_URLS]);
        $this->assertTrue($view->vars[RichEditorType::OPTION_RELATIVE_URLS]);
        $this->assertFalse($view->vars[RichEditorType::OPTION_BROWSER_SPELLCHECK]);
        $this->assertFalse($view->vars[RichEditorType::OPTION_PASTE_AS_TEXT]);
        $this->assertSame('named', $view->vars[RichEditorType::OPTION_ENTITY_ENCODING]);
        $this->assertSame(['pl', 'en'], $view->vars[RichEditorType::OPTION_SPELLCHECKER_LANGUAGES]);
        $this->assertSame(['lists'], $view->vars[RichEditorType::OPTION_PLUGINS]);
        $this->assertSame('bold italic', $view->vars[RichEditorType::OPTION_TOOLBAR]);
    }
}
