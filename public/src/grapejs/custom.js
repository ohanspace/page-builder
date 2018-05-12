var editor = grapesjs.init({
    container: '#gjs',
    plugins: ['gjs-blocks-basic']
});

// commands
var commandManager = editor.Commands;
commandManager.add('saveTemplate', {
    run: function(editor, senderBtn) {
        senderBtn.set('active', false);
        var data = {
            html: editor.getHtml(),
            css: editor.getCss(),
            js: editor.getJs()
        };
        console.log(data);
    },
    stop: function(editor, sender) {}
});

commandManager.add('show-page-manager', {
    contents: null,
    run: function run(editor) {
        var pn = editor.Panels;

        var id = 'views-container';
        var contents = document.querySelector('#pages-panel');
        this.contents = contents;

        var panel = pn.getPanel(id) || pn.addPanel({ id: id });
        panel.set('appendContent', contents).trigger('change:appendContent');

        contents.style.display = 'block';
        //console.log(panel);
    },

    stop: function stop() {
        var contents = this.contents;
        contents && (contents.style.display = 'none');
    }
});

// panels
var panelManager = editor.Panels;

panelManager.addButton('options', {
    // to 'options' panel
    id: 'save-template-btn',
    command: 'saveTemplate',
    className: 'fa fa-save'
});
panelManager.addButton('views', {
    // to 'options' panel
    id: 'page-module-btn',
    command: 'show-page-manager',
    className: 'fa fa-save',
    attributes: { active: true }
});
