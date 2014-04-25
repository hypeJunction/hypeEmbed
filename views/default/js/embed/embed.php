//<script>
	elgg.provide('elgg.embed');
	elgg.embed.textAreaId = null;
	elgg.embed.init = function() {

		$(window).resize(function(e) {
			if ($('#embed-modal').length) {
				$('#embed-modal').dialog({
					position: {my: "center", at: "center", of: window}
				});
			}
		});

		$('body.embed-state-loading').live('click', function() {
			$(this).removeClass('embed-state-loading');
		});
		$('.embed-control, .embed-wrapper .elgg-pagination a, .embed-section').live('click', elgg.embed.loader);
		$('.embed-wrapper .elgg-form-embed-search').live('submit', elgg.embed.search);
		$('.embed-wrapper form[enctype^="multipart"]').live('submit', elgg.embed.upload);
		$('.embed-wrapper .elgg-form-embed-src').live('submit', elgg.embed.embedSrc);
		$(".embed-insert").live('click', elgg.embed.insert);

	};
	/**
	 * Loads embed content into a modal
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
				$('body').addClass('embed-state-loading');
			},
			success: function(data) {
				if (data.status >= 0) {
					if ($wrapper.length) {
						$wrapper.replaceWith(data.output);
					} else {
						elgg.embed.lightboxOpen(data.output);
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
				$('body').removeClass('embed-state-loading');
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
				'X-Requested-With': 'XMLHttpRequest', // simulate XHR
				container_guid: elgg.get_page_owner_guid()
			},
			beforeSend: function() {
				$('body').addClass('embed-state-loading');
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
				$('body').removeClass('embed-state-loading');
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
				'X-Requested-With': 'XMLHttpRequest', // simulate XHR
				container_guid: elgg.get_page_owner_guid()
			},
			beforeSend: function() {
				$('body').addClass('embed-state-loading');
			},
			success: function(data) {
				if (data.status >= 0) {
					$textArea.val($textArea.val() + data.output);
					$textArea.focus();
					var insert = elgg.trigger_hook('insert', 'embed', {
						target_id: textAreaId,
						content: data.output
					}, false);
					elgg.embed.lightboxClose();
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
				$('body').removeClass('embed-state-loading');
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
				$('body').addClass('embed-state-loading');
			},
			success: function(data) {
				if (data.status >= 0) {
					var forward = $('.embed-wrapper [name="embed_forward"]').val();
					if (!forward) {
						forward = 'file';
					}
					$('.embed-section.embed-section-' + forward).trigger('click');
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
				$('body').removeClass('embed-state-loading');
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
				$('body').addClass('embed-state-loading');
			},
			success: function(data) {
				if (typeof data !== 'string' && data.output) {
					data = data.output;
				}
				$textArea.val($textArea.val() + data);
				$textArea.focus();
				var insert = elgg.trigger_hook('insert', 'embed', {
					target_id: textAreaId,
					content: data
				}, false);
				elgg.embed.lightboxClose();
			},
			error: function() {
				elgg.register_error(elgg.echo('embed:error:ajax'));
			},
			complete: function() {
				$('body').removeClass('embed-state-loading');
			}
		});
	};
	elgg.embed.insertTinyMce = function(hook, type, params) {

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

	elgg.embed.lightboxOpen = function(content) {

		$('<div id="embed-modal" />').html(content).dialog({
			title: null,
			dialogClass: 'embed-modal',
			width: 'auto',
			modal: true,
			close: function() {
				$(this).dialog('destroy').remove();
			},
			position: {my: "center", at: "center", of: window}
		})
	};

	elgg.embed.lightboxClose = function() {
		$('#embed-modal').dialog('close');
	}

	elgg.register_hook_handler('init', 'system', elgg.embed.init);
	elgg.register_hook_handler('insert', 'embed', elgg.embed.insertTinyMce);


