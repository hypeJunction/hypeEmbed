//<script>
	elgg.provide('elgg.embed');

	elgg.embed.textAreaId = null;

	elgg.embed.init = function() {

		$('.embed-control, .embed-wrapper .elgg-pagination a, .embed-section').live('click', elgg.embed.loader);
		$('.embed-wrapper .elgg-form-embed-search').live('submit', elgg.embed.search);
		$('.embed-wrapper .elgg-form-embed-upload').live('submit', elgg.embed.upload);
		$('.embed-wrapper .elgg-form-embed-src').live('submit', elgg.embed.embedSrc);


		$(".embed-insert").live('click', elgg.embed.insert);

	};

	/**
	 * Loads embed content into a lightbox
	 */
	elgg.embed.loader = function(event) {

		event.preventDefault();

		var $elem = $(this);

		if ($elem.is('.embed-control')) {
			elgg.embed.textAreaId = $(this).data('textareaId');
		}

		var $wrapper = $('.embed-wrapper');

		elgg.ajax($elem.attr('href'), {
			dataType: 'json',
			data: {
				container_guid: elgg.get_page_owner_guid()
			},
			beforeSend: function() {
				$.fancybox.showActivity();
			},
			success: function(data) {
				if (data.status >= 0) {
					if ($wrapper.length) {
						$wrapper.replaceWith(data.output);
					} else {
						$.fancybox({
							content: data.output,
						});
					}
				}
				if (data.system_messages) {
					elgg.register_error(data.system_messages.error);
					elgg.system_message(data.system_messages.success);
				}
			},
			error: function() {
				elgg.register_error(elgg.echo('embed:error:ajax'));
			},
			complete: function() {
				$.fancybox.hideActivity();
			}
		});
	}

	/**
	 * Triggers ajax submit of the search form
	 */
	elgg.embed.search = function(event) {

		event.preventDefault();

		var $form = $(this);

		var $wrapper = $form.closest('.embed-wrapper');

		$form.ajaxSubmit({
			dataType: 'json',
			data: {
				container_guid: elgg.get_page_owner_guid()
			},
			beforeSend: function() {
				$.fancybox.showActivity();
			},
			success: function(data) {
				if (data.status >= 0) {
					$wrapper.replaceWith(data.output);
				}
				if (data.system_messages) {
					elgg.register_error(data.system_messages.error);
					elgg.system_message(data.system_messages.success);
				}
			},
			error: function() {
				elgg.register_error(elgg.echo('embed:error:search'));
			},
			complete: function() {
				$.fancybox.hideActivity();
			}
		});
	}

	elgg.embed.embedSrc = function(event) {

		event.preventDefault();

		var $form = $(this);

		var $wrapper = $form.closest('.embed-wrapper');

		var textAreaId = elgg.embed.textAreaId;
		var $textArea = $('#' + textAreaId);

		$form.ajaxSubmit({
			dataType: 'json',
			data: {
				container_guid: elgg.get_page_owner_guid()
			},
			beforeSend: function() {
				$.fancybox.showActivity();
			},
			success: function(data) {
				if (data.status >= 0) {
					$textArea.val($textArea.val() + data);
					$textArea.focus();

					var insert = elgg.trigger_hook('insert', 'embed', {
						target_id: textAreaId,
						content: data.output
					}, false);

					$.fancybox.close();
				}
				if (data.system_messages) {
					elgg.register_error(data.system_messages.error);
					elgg.system_message(data.system_messages.success);
				}
			},
			error: function() {
				elgg.register_error(elgg.echo('embed:error:ajax'));
			},
			complete: function() {
				$.fancybox.hideActivity();
			}
		});
	}

	/**
	 * Upload a file via ajax
	 */
	elgg.embed.upload = function(event) {

		event.preventDefault();
		event.stopPropagation();

		var $form = $(this);

		var $wrapper = $form.closest('.embed-wrapper');

		$form.ajaxSubmit({
			dataType: 'json',
			data: {
				'X-Requested-With': 'XMLHttpRequest', // simulate XHR
				container_guid: elgg.get_page_owner_guid()
			},
			beforeSend: function() {
				$form.find('[type="submit"]').addClass('elgg-state-disabled').text(elgg.echo('embed:process:uploading')).prop('disabled', true);
				$.fancybox.showActivity();
			},
			success: function(data) {
				if (data.status >= 0) {
					$('.embed-section.embed-section-file').trigger('click');
				}
				if (data.system_messages) {
					elgg.register_error(data.system_messages.error);
					elgg.system_message(data.system_messages.success);
				}
			},
			error: function() {
				elgg.register_error(elgg.echo('embed:error:ajax'));
				$form.find('[type="submit"]').removeClass('elgg-state-disabled').text(elgg.echo('upload')).prop('disabled', false);
			},
			complete: function() {
				$.fancybox.hideActivity();
			}
		});
	};

	elgg.embed.insert = function(event) {

		event.preventDefault();

		var $elem = $(this);

		var textAreaId = elgg.embed.textAreaId;
		var $textArea = $('#' + textAreaId);

		elgg.ajax($elem.attr('href'), {
			beforeSend: function() {
				$.fancybox.showActivity();
			},
			success: function(data) {
				$textArea.val($textArea.val() + data);
				$textArea.focus();

				var insert = elgg.trigger_hook('insert', 'embed', {
					target_id: textAreaId,
					content: data
				}, false);

				$.fancybox.close();
			},
			error: function() {
				elgg.register_error(elgg.echo('embed:error:ajax'));
			},
			complete: function() {
				$.fancybox.hideActivity();
			}
		});
	};

	elgg.embed.insertTinyMce = function(hook, type, params) {
		console.log(params);
		if (window.tinyMCE) {
			var editor = window.tinyMCE.get(params.target_id);

			if (editor) {

				// work around for IE/TinyMCE bug where TinyMCE loses insert carot
				if ($.browser.msie) {
					editor.focus();
					editor.selection.moveToBookmark(elgg.tinymce.bookmark);
				}

				editor.execCommand("mceInsertContent", true, params.content);
			}
		}
	}

	elgg.register_hook_handler('init', 'system', elgg.embed.init);
	elgg.register_hook_handler('insert', 'embed', elgg.embed.insertTinyMce);


