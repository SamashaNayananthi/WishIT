var base_url = $('#base').val();

var User = Backbone.Model.extend({
    url: base_url + "api/User/users",
    idAttribute: 'id',
    defaults: {"id": null, "fname": "", "lname": ""}
});

var user = new User();

var UserView = Backbone.View.extend({
    el: '#loggedInUser',
    initialize : function () {
        this.listenTo(this.model, 'sync', this.render);
        this.model.fetch({async:false});
    },
    render : function () {
        var html = '<div class="user-name">' + this.model.get('fname') +
            '<i class="fa fa-sort-down icon"></i></div>';
        this.$el.html(html);
    }
});

var userView = new UserView({model:user});