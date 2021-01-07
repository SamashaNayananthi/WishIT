var base_url = $('#base').val();

var List = Backbone.Model.extend({
    url: base_url + "api/ListDetails/list",
    idAttribute: 'id',
    defaults: {"id": null, "name": "", "description": "", "occasionId": null,
        "occasion":"", "userId": null}
});

var list = new List();

var ListView = Backbone.View.extend({
    el: '#listMain',
    initialize: function () {
        this.listenTo(this.model, 'sync', this.render);
        this.model.fetch();
        divVisibilityChange();
    },
    render: function () {
        divVisibilityChange();

        var html = '<div class="list-heading">' +
            '<div class="list-name" data-toggle="tooltip" data-placement="bottom" title="' +
            this.model.get('name') + '">' + this.model.get('name') + '</div>' +
            '<div class="vl">|</div>' +
            '<div class="occasion">' + this.model.get('occasion') + '</div></div>' +
            '<div class="list-note" data-toggle="tooltip" data-placement="bottom" title="' +
            this.model.get('description') + '">' + this.model.get('description') + '</div>';

        this.$el.html(html);
        return this;
    },
    wait: true
});

var listView = new ListView({model:list});

var listPopup = document.getElementById("listPopup");

function closeListPopup() {
    listPopup.style.display = "none";
}

function openList(action) {
    if (action === 'add') {
        document.getElementById("listPopupHeading").innerHTML = 'Create Wish List';
        document.getElementById("addListBtn").style.display = 'block';
        document.getElementById("editListBtn").style.display = 'none';
        listPopup.style.display = "block";
    } else {
        document.getElementById("listPopupHeading").innerHTML = 'Edit Wish List';
        document.getElementById("addListBtn").style.display = 'none';
        document.getElementById("editListBtn").style.display = 'block';
        document.getElementById("name").value = list.get('name');
        document.getElementById("desc").value = list.get('description');
        document.getElementById("occasion").value = list.get('occasionId');
        listPopup.style.display = "block";
    }
}

function onSubmitList(action) {
    var name = document.getElementById("name").value;
    var desc = document.getElementById("desc").value;
    var occasion = document.getElementById("occasion").value;

    if (name !== '' && desc !== '') {
        if (action === 'add') {
            list.set('id',null);
        }
        list.set('name', name);
        list.set('description', desc);
        list.set('occasionId', occasion);
        list.set('userId', user.get('id'));
        list.save(null, { async: false,
            success: function () {
                listPopup.style.display = "none";
                document.getElementById("name").value = '';
                document.getElementById("desc").value = '';
                document.getElementById("occasion").value = '';
            },
            error: function () {
                if (action === 'add') {
                    alert('Error occurred while creating the list.');
                } else {
                    alert('Error occurred while editing the list.');
                }
            }
        });

    } else  {
        alert('Please fill all the required fields.');
    }
}

var listDeletePopup = document.getElementById("deleteListPopup");

function closeDeleteListPopup() {
    listDeletePopup.style.display = "none";
}

function openDeleteList() {
    document.getElementById("deleteListMsg").innerHTML = "Are you sure ? <br> Your wish list '" +
        list.get('name') + "' and related items will be deleted. ";
    listDeletePopup.style.display = "block";
}

function onClickDeleteList() {
    list.destroy({ url: base_url + "api/ListDetails/list/id/" + list.get('id'),
        success: function () {
            list.clear().set(list.defaults);
            divVisibilityChange();
            listDeletePopup.style.display = "none";
        },
        error: function () {
            alert('Error occurred while deleting the list.');
        }
    });
}

var shareablePopup = document.getElementById("shareablePopup");

function closeShareablePopup() {
    shareablePopup.style.display = "none";
}

function shareableLink() {
    $.ajax({
        url: base_url + "api/ListDetails/shareableLink",
        method: "GET",
        success: function(response) {
        document.getElementById("shareableLink").value = response;
        shareablePopup.style.display = "block";
    },
    error: function () {
        alert('Error occurred while getting shareable link.');
    }
});
}

function onClickCopyToClipboard() {
    var copiedText = document.getElementById("shareableLink");
    copiedText.select();
    copiedText.setSelectionRange(0, 99999)
    document.execCommand("copy");
}

