define([
    'uiComponent',
    'jquery',
    'ko'
], function (Component, $, ko) {
    'use strict';
    return Component.extend({
        defaults: {
            isLoading: ko.observable(false),
            count: ko.observable(''),
            url: ''
        },

        initialize: function () {
            this._super();
            return this;
        },


        countStock: function () {

            this.isLoading(true);
            var self = this;
            $.ajax({
                url: self.url,
                type: 'POST',
                data: {product_id:self.product_id},
                dataType: 'json'
            }).done(function (data) {
                // data = JSON.parse(data);
                debugger
                if(data){
                    self.count(data);
                }
            }).always(function () {
                self.isLoading(false);
            });
        }
    });
});
