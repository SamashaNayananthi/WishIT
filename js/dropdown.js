var base_url = $('#base').val();

var Occasion = Backbone.Model.extend({
    url: base_url + "api/Occasion/occasion",
    idAttribute: 'id',
    defaults: {"id": null, "name": ""}
});

var Occasions = Backbone.Collection.extend({
    model: Occasion,
    url: base_url + "api/Occasion/occasion"
});

var occasionList = new Occasions();

var OccasionView = Backbone.View.extend({
    el: '#occasion',
    initialize : function () {
        this.model.fetch({async:false});
        this.listenTo(this.model, 'sync', this.render());
    },
    render : function () {
        var html = '';
        this.model.each(function (occasion) {
            html += '<option value="' + occasion.get('id') + '">' + occasion.get('name') + '</option>';
        });
        this.$el.html(html);
    }
});

var occasionView = new OccasionView({model:occasionList});

var Priority = Backbone.Model.extend({
    url: base_url + "api/Priority/priority",
    idAttribute: 'id',
    defaults: {"id": null, "priority": null, "name": ""}
});

var Priorities = Backbone.Collection.extend({
    model: Priority,
    url: base_url + "api/Priority/priority"
});

var priorityList = new Priorities();

var PriorityView = Backbone.View.extend({
    el: '#priority',
    initialize : function () {
        this.model.fetch({async:false});
        this.listenTo(this.model, 'sync', this.render());
    },
    render : function () {
        var html = '';
        this.model.each(function (priority) {
            html += '<option value="' + priority.get('id') + '">' + priority.get('name') + '</option>';
        });
        this.$el.html(html);
    }
});

var priorityView = new PriorityView({model:priorityList});