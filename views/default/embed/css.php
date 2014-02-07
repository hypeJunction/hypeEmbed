<?php if (FALSE) : ?><style type="text/css"><?php endif; ?>

	/* ***************************************
		TOP LEVEL ELEMENTS
	*************************************** */

	body.embed-state-loading:before {
		display: block;
		width: 100%;
		height: 100%;
		position: fixed;
		z-index: 10000;
		background: rgba(255, 255, 255, 0.5) url('<?php echo elgg_get_site_url() . '_graphics/ajax_loader_bw.gif' ?>') no-repeat 50% 50%;
		content: " ";
	}

	.embed-wrapper {
		width: 730px;
		min-height: 400px;
		margin: 20px 15px;
	}
	.embed-wrapper h2 {
		color: #333333;
		margin-bottom: 10px;
	}
	.embed-wrapper .elgg-item {
		cursor: pointer;
	}

	/* ***************************************
		EMBED TABBED PAGE NAVIGATION
	*************************************** */
	.embed-wrapper p {
		color: #333;
	}
	.embed-item {
		padding-left: 5px;
		padding-right: 5px;
	}
	.embed-item:hover {
		background-color: #eee;
	}

	/* ***************************************
		EMBED FORMS
	*************************************** */
	.elgg-form-embed-search {
		padding: 10px;
		margin-bottom: 10px;
		border-bottom: 1px solid #e8e8e8;
	}
	.elgg-form-embed-search fieldset > div {
		display: inline-block;
		margin: 0;
	}
	.elgg-form-embed-search label {
		display: inline-block;
		margin-right: 10px;
	}
	.elgg-form-embed-search input {
		width: auto;
	}
	.ebmed-wrapper fieldset {
		margin: 0;
		padding: 0;
		border: none;
	}
	.embed-wrapper .elgg-image-block {
		width: auto;
	}

	/* ***************************************
		EMBED ECML
	*************************************** */

	.embed-ecml-placeholder {
		max-width: 100%;
		padding: 20px 10px;
		margin: 10px 0;
		-moz-box-sizing: border-box;
		-webkit-box-sizing: border-box;
		box-sizing: border-box;
		border-width: 1px 0;
		border-style: solid;
		border-color: #ccc;
	}
	.embed-ecml-error {
		border-color: darkred;
	}
	.embed-ecml-error h3 {
		color: darkred;
	}