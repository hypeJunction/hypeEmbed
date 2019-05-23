define(function (require) {
	var $ = require('jquery');
	var elgg = require('elgg');
	var Ajax = require('elgg/Ajax');
	require('embed/lists/item');

	$(document).on('click', '.elgg-menu-embed > li > a', function (e) {
		e.preventDefault();

		var $trigger = $(this);
		var $target = $trigger.closest('.embed-toolbar').find('.embed-toolbar-popup');

		$(document).on('scroll', function () {
			$target.position($target.data('position'));
		});

		require(['elgg/popup'], function (popup) {
			popup.open($trigger, $target, {
				'collision': 'fit none',
				'my': 'left top+8px',
				'at': 'left bottom',
				'of': $trigger.closest('.embed-toolbar'),
			});
		});

		$target.on('open', function () {
			var $module = $(this);
			var $trigger = $module.data('trigger');

			var ajax = new Ajax(false);

			$target.html('');
			$target.addClass('elgg-ajax-loader');

			ajax.path($trigger.data('href'))
				.done(function (view) {
					$trigger.parent().addClass('elgg-state-active');
					$target.html(view);
					$target.find('textarea,input[type="text"]').first().focus();
				})
				.always(function () {
					$target.removeClass('elgg-ajax-loader');
				});
		}).on('close', function () {
			var $trigger = $(this).data('trigger');

			$trigger.parent().removeClass('elgg-state-active');
		});
	});
});