define([
    'uiComponent',
    'jquery',
    'ko',
    'Magento_Ui/js/modal/modal'
], function (Component, $, ko, modal) {
    'use strict';
    return Component.extend({
        defaults: {
            isLoading: ko.observable(false),
            url: '',
            product_id: 0
        },

        initialize: function () {
            this._super();
            return this;
        },



        buttonPrice: function () {

            var self = this;

            var modaloption = {
                type: 'popup',
                // modalClass: 'modal-popup',
                responsive: true,
                innerScroll: true,
                // clickableOverlay: true,
                title: $.mage.__('Request Price'),
                buttons: [
                    {
                        text: $.mage.__('Confirm'),
                        attr: {
                            'data-action': 'confirm',
                            'data-url': self.url
                        },
                        'class': 'button-price-confirm action-primary',
                        click: self.sendRequest
                    },
                    {
                        text: $.mage.__('Cancel'),
                        attr: {
                            'data-action': 'cancel'
                        },
                        'class': 'action-primary',
                        click: self.closeModal
                    }]
            };

            var callforoption = modal(modaloption, $('.callfor-popup'));
            $('.callfor-popup').modal('openModal');


        },

        closeModal:function (){
            $('.callfor-popup').modal('closeModal');
        },

        sendRequest: function (){

            var url = $('.button-price-confirm').data('url');

            $.ajax({
                url: url,
                type: 'POST',
                data: $('.callfor-popup input,.callfor-popup textarea').serialize(),
                dataType: 'json'
            }).done(function (data) {
                // data = JSON.parse(data);
                console.log(data);
            }).error(function (jqXHR, exception) {
                console.log(jqXHR);
            })
        }
    });
});
