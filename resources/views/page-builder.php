<link rel="stylesheet" href="./src/grapejs/css/grapes.min.css">
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.12/css/all.css" integrity="sha384-G0fIWCsCzJIMAVNQPfjH08cyYaUtMwjJwqiRKxxE/rx96Uroj1BtIQ6MLJuheaO9"
    crossorigin="anonymous">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="src/grapejs/grapes.js"></script>
<script src="src/grapejs/grapes-block-basic.min.js"></script>

<div id="gjs"></div>

<!-- pages panel -->
<div id="pages-panel">
    Pages
    <button onClick="createNewPage()">+</button>

    <!-- page list -->
    <div>
        <ul id="page-list">
        </ul>
    </div>
    <!-- page form -->
    <div id="page-edit-form" hidden>
        <input type="text" name="title">
        <button onClick="savePage()">Save</button>
        <button onClick="hidePageEditForm()">Cancel</button>
        <button onClick="deletePage()">Delete</button>
    </div>
</div>

<script type="text/javascript" src="src/grapejs/custom.js"></script>
<script>
    var pageEditFormEl = $('#page-edit-form');
    var pageListEl = $('#page-list');
    var currentPage; //currently in the canvas

    function initPageSettingsModule() {
        populatePageList();
    }

    function createNewPage() {
        currentPage = getDefaultPage();

        editor.setComponents('');
        editPage(currentPage);
    }

    function getDefaultPage() {
        return {
            title: 'Default Page',
            html: '<h1>This is Default Page</h1>'
        }
    }


    function savePage() {
        const title = pageEditFormEl.find("[name='title']").val();
        const slug = makeSlug(title);
        const html = editor.getHtml();
        const css = editor.getCss();

        Object.assign(currentPage, {
            title: title,
            slug: slug,
            html: html,
            css: css
        });

        PageRepository.save(currentPage);
        //console.log(currentPage);
    }


    function deletePage() {
        //console.log(currentPage.id);
        PageRepository.deleteById(currentPage);
    }

    function populatePageList() {

        var pages = PageRepository.pages;
        hidePageEditForm();
        pageListEl.children().remove();
        for (i = 0; i < pages.length; i++) {
            var page = pages[i];
            var li = $('<li></li>')
                .text(page.title);
            li.click(page, function ($event) {
                editPage($event.data)
            });
            pageListEl.append(li);
        }

        //console.log(currentPage);
        if (!pages.length && !currentPage) {
            currentPage = getDefaultPage();
            showPageEditForm(currentPage);
        }

        currentPage = currentPage || pages[0];
        renderPage(currentPage);

    }

    function editPage(page) {
        renderPage(page);
        showPageEditForm(page);
    }

    function showPageEditForm(page) {
        pageEditFormEl.show();
        pageListEl.hide();

        var titleEl = pageEditFormEl.find("[name = 'title']").first();
        titleEl.val(page.title);
        //console.log(titleEl, page);

    }

    function hidePageEditForm() {
        pageEditFormEl.hide();
        pageListEl.show();
    }


    function renderPage(page) {
        currentPage = page;
        //console.log($event.data);
        editor.setComponents(page.html);
    }



    function makeSlug(s) {
        return s.toLowerCase()
            .replace(/[^\w ]+/g, '')
            .replace(/ +/g, '-');
    }


    // singleton page repository
    var PageRepository = new function () {
        this.pages = [
            { id: 1, slug: 'about', title: 'About', html: '<h1>About</h1>', css: 'h1{color:red}' },
            { id: 2, slug: 'contact', title: 'Contact', html: '<h1>Contact</h1>', css: 'h1{color:green}' }
        ];

        this.save = function (page) {
            if (page.id) {
                this.update(page);
            } else {
                this.create(page);
            }

            populatePageList();
        }

        this.create = function (page) {
            page.id = 3; // TODO page id from server
            this.pages.push(page);
        }

        this.update = function (page) {
            //console.log('updating', page);
            const index = this.getIndexByPageId(page.id);
            if (index !== -1) {
                this.pages[index] = page;
            }
        }

        this.deleteById = function (page) {
            const index = this.getIndexByPageId(page.id);
            if (index !== -1) {
                this.pages.splice(index, 1);
                currentPage = null;
            }
            populatePageList();
        }

        this.getIndexByPageId = function (id) {
            return findWithAttr(this.pages, 'id', id);
        }

    }

    /*
    * return index of a object in an array
    * if no matched obj then return -1
    * [ obj1 , obj2, ... ]
    **/
    function findWithAttr(array, attr, value) {
        for (var i = 0; i < array.length; i += 1) {
            if (array[i][attr] === value) {
                return i;
            }
        }
        return -1;
    }




    initPageSettingsModule();
</script>