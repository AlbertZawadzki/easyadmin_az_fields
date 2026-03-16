const richEditorFieldClass = 'ea-az-rich-editor-field';

document.addEventListener('DOMContentLoaded', async () => {
    const editors = document.querySelectorAll(`.${richEditorFieldClass}`);
    const isDarkTheme = document.body.classList.contains("ea-dark-scheme");
  
    editors.forEach((element) => {
        tinymce.init({
            target: element,
            skin: isDarkTheme ? 'oxide-dark' : 'oxide',
            content_css: isDarkTheme ? 'dark' : 'light',

            allow_script_urls: element.dataset.allowScriptUrls,
            relative_urls: element.dataset.relativeUrls,
            language: element.dataset.language,
            spellchecker_languages: element.dataset.spellcheckerLanguages,
            height: parseInt(element.dataset.height),
            entity_encoding: element.dataset.entityEncoding,
            browser_spellcheck: element.dataset.browserSpellcheck,
            plugins: element.dataset.plugins,
            toolbar: element.dataset.toolbar,
            paste_as_text: element.dataset.pasteAsText,
        });
    });
});

