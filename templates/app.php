<?php
/**
 * Template Name: App
 */

defined( 'ABSPATH' ) || die( "Can't access directly" );

get_header(); ?>

<div id="root">
</div>
<script id="welcome-template" type="text/x-handlebars-template">
	<div class="welcome sliding-page">
		<div class="header">
			<div class="title font-normal">{{title}}</div>
			<div class="subtitle">
				<span>{{subtitle}}</span>
			</div>
		</div>
		<div class="main">
			<img src="{{thumbnail}}" alt="">
			<div class="description">
				{{{description}}}
			</div>
			<a class="btn btn-dark btn-block" href="/#/category">{{cta_button.text}}</a>
		</div>
		{{> footerTemplate }}
	</div>
</script>
<script id="page-template" type="text/x-handlebars-template">
	<div class="app-page sliding-page">
		{{> headerTemplate }}
		<div class="main">
			{{#if isIndex}}
				{{> indexTemplate }}
			{{/if}}
			{{#if isTasks}}
				{{> tasksTemplate }}
			{{/if}}
			{{#if isTasksDetail}}
				{{> tasksDetailTemplate }}
			{{/if}}
			{{#if isProductList}}
				{{> productListTemplate }}
			{{/if}}
			{{#if isProductDetail}}
				{{> productDetailTemplate }}
			{{/if}}
			{{#if isContact}}
				{{> contactTemplate }}
			{{/if}}
			{{#if isFaq}}
				{{> faqTemplate }}
			{{/if}}
			{{#if isTipsList}}
				{{> tipsListTemplate }}
			{{/if}}
			{{#if isTipsDetail}}
				{{> tipsDetailTemplate }}
			{{/if}}
		</div>
		{{> footerTemplate }}
	</div>
</script>
<script id="header-template" type="text/x-handlebars-template">
	<div class="header">
		<div class="title-bar bg-primary font-bold">
			<div class="left text-white">
				{{#if showBackBtn}}
					<button class="back-btn"><i class="fas fa-arrow-left"></i></button>
				{{/if}}
				{{#if showMenuBtn}}
					<button id="open-menu-btn" class="open-menu-btn"><i class="fas fa-bars"></i></button>
				{{/if}}
			</div>
			<div class="title text-white">
				{{title}}
			</div>
			<div class="right text-white">

			</div>
		</div>
	</div>
</script>
<script id="footer-template" type="text/x-handlebars-template">
	<div class="footer">
		{{{powered_by}}}
	</div>
</script>
<script id="index-template" type="text/x-handlebars-template">
	<div class="index">
		<div id="menu" class="menu">
			<div class="menu-flex">
				<div class="menu-inner">
					<div class="header"><span>Hardcoded App Name</span><button id="close-menu-btn"><i class="far fa-times"></i></button></div>
					<ul>
						{{#each menus}}
							<li {{#if @index}}{{else}} {{/if}} >
								<a href="/#/{{menuTarget}}" class="">
									<i class="{{icon}}"></i><span>{{text}}</span>
								</a>
							</li>
						{{/each}}
					</ul>
					<div class="footer font-normal">
						{{{powered_by}}}
					</div>
				</div>
			</div>
		</div>
		<div class="categories">
			{{#each categories}}
			<a class="category text-white" href="/#/category/{{slug}}" style="background-color:{{bg_color}}" >
				<div class="wrapper">
					<div class="label font-normal">{{name}}</div>
					<img src="{{icon}}" alt="">
				</div>
			</a>
			{{/each}}
		</div>
	</div>
</script>
<script id="tasks-template" type="text/x-handlebars-template">
	<div class="tasks-page">
		{{#if categoryHeaderImage}}
		<div class="banner">
			<img src="{{categoryHeaderImage}}" alt="">
		</div>
		{{/if}}
		<div class="tasks">
			{{#each tasks}}
				<a class="task" href="/#/category/{{parentCategory}}/{{post_name}}">
					<div class="label font-bold text-white bg-primary">
						<div class="font-normal">{{post_title}}</div>
						{{#if frequency}}
						<div class="frequency font-normal"><i class="fas fa-clock"></i>&nbsp;&nbsp;{{frequency}}</div>
						{{/if}}
					</div>
					<div class="arrow bg-primary">
						<i class="fab fa-sass text-white"></i>
					</div>
				</a>
			{{/each}}
        </div>
        {{#if tips}}
            {{>floatTemplate}}
        {{/if}}
	</div> <!-- end of tasks-page -->
</script>
<script id="tasks-detail-template" type="text/x-handlebars-template">
	<div class="task-detail">
		<div class="banner">
			{{#if isLocalVideo}}
				<div>
					<video id="media-element" src="{{coverUrl}}" poster="{{coverThumbnail}}"></video>
				</div>
			{{/if}}
			{{#if isImage}}
				<img src="{{coverUrl}}" alt="">
			{{/if}}
			{{#if isEmbed}}
				<div class="embed">
					{{{embed}}}
				</div>
			{{/if}}
		</div>
		{{#if taskFrequency}}
		<div class="frequency font-normal">
			<i class="fas fa-clock"></i>&nbsp; {{taskFrequency}}
		</div>
		{{/if}}
		<div class="details">
			<button class="btn btn-secondary btn-block btn-checklist btn-material" data-task-id="{{taskId}}">
				<div class="icon">
					<i class="fas fa-exclamation-circle"></i>
				</div>
				<div class="label">
					{{material_needed}}
				</div>
			</button>
			<div class="list">
				{{#each steps}}
				<div class="item">
					<div class="left"><span class="number">{{inc @index}}</span></div>
					<div class="right">
						<div class="font-normal text">
							{{name}}
						</div>
						{{#if has_warning}}
							<div class="warning">
								<button class="btn btn-outline-secondary btn-sm btn-checklist font-normal" data-product-id="{{material}}" data-task-id="{{taskId}}"><i class="fas fa-exclamation-triangle"></i> Hardcoded label</button>
							</div>
						{{/if}}
					</div>
				</div>
				{{/each}}
			</div>
			<button class="btn btn-secondary btn-block btn-checklist" data-task-id="{{taskId}}">
				<i class="fas fa-exclamation-circle"></i>
				<span><?php _e( 'Hardcoded Label', 'asvz' ); ?></span>
			</button>
		</div>
		{{#if steps}}
		{{> floatTemplate }}
		{{/if}}
	</div>
</script>
<script id="product-list-template" type="text/x-handlebars-template">
	<div class="products">
		{{#each materials}}
			<a href="/#/product/{{post_name}}" class="product">
				<div class="image">
					<img src="{{thumbnail}}" alt="Item thumbnail">
				</div>
				<h3>{{post_title}}</h3>
				<i class="far text-white fa-chevron-right"></i>
			</a>
		{{/each}}
	</div>
</script>
<script id="product-detail-template" type="text/x-handlebars-template">
	<div id="product-slider" class="owl-carousel owl-theme product-slider">
		{{#each carousel_images}}
			<div class="item" style="">
				<img src="{{sizes.medium_square}}" alt="">
			</div>
		{{/each}}
	</div>
	<div class="product-detail">
		<h2 class="text-blue">{{post_title}}</h2>
		<div class="description font-normal">
			{{{description}}}
        </div>
        {{#if risks}}
            <div class="risks">
                <h3><i class="fas fa-skull-crossbones fa-fw text-pink"></i> <?php _e( "Risico's", 'asvz' ); ?></h3>
                {{#each risks}}
                    <div class="risk accordion">
                        <div class="header">
                            <i class="{{icon}} fa-fw text-blue"></i>
                            <div class="message closed font-normal">{{{message}}}</div>
                            <i class="far fa-chevron-down fa-fw text-blue arrow"></i>
                        </div>
                    </div>
                {{/each}}
            </div>
        {{/if}}
        {{#if alternatives}}
            <div class="alternative">
                <h3><i class="fas fa-wine-bottle fa-fw text-pink"></i> <?php _e( 'Alternatief product', 'asvz' ); ?></h3>
                {{#if alternatives}}
                    {{#each alternatives}}
                    <a href="/#/product/{{post_name}}" class="plain-link" data-target="{{post_name}}" data-depth="5">
                        <div class="product">
                            <div class="image">
                                <img src="{{thumbnail}}" alt="">
                            </div>
                            <div class="description">
                                <h4 class="name">{{post_title}}</h4>
                                <div class="number font-normal">Productnummer: {{product_number}}</div>
                            </div>
                        </div>
                    </a>
                    {{/each}}
                {{else}}
                    <div class="font-normal">Dit product is beschikbaar in de ASVZ webwinkel.</div>
                {{/if}}
            </div>
        {{/if}}
	</div>
</script>
<script id="contact-template" type="text/x-handlebars-template">
	<div class="contact font-normal">
		<form action="" method="post">
			<div class="input-group">
				<label class="label" for="subject">
					<i class="fas fa-file-alt"></i> {{contact.labels.subject}}
				</label>
				<input id="subject" type="text" name="subject" placeholder="{{contact.placeholders.subject}}" required>
			</div>
			<div class="input-group">
				<label class="label" for="name">
					<i class="fas fa-user"></i> {{contact.labels.name}}
				</label>
				<input class="" id="name" type="text" name="name" placeholder="{{contact.placeholders.name}}" required>
			</div>
			<div class="input-group">
				<label class="label" for="email">
					<i class="fas fa-envelope"></i> {{contact.labels.email}}
				</label>
				<input id="email" type="email" name="email" placeholder="{{contact.placeholders.email}}" required>
			</div>
			<div class="input-group">
				<label class="label" for="body">
					<i class="fas fa-comment-alt-dots"></i> {{contact.labels.body}}
				</label>
				<textarea id="body" name="body" placeholder="{{contact.placeholders.body}}" required></textarea>
			</div>
			<button type="submit" class="btn btn-pink btn-block btn-contact font-bold"><span>{{contact.labels.button}}</span><span><i class="fas fa-arrow-right"></i></span></button>
		</form>
	</div>
</script>
<script id="faq-template" type="text/x-handlebars-template">
	<div class="faq">
		{{#each questions}}
			<div class="question accordion">
				<div class="header">
					<div class="text">{{post_title}}</div>
					<i class="far fa-chevron-down fa-fw text-white arrow"></i>
				</div>
				<div class="body closed font-normal">
					{{{post_content}}}
				</div>
			</div>
		{{/each}}
	</div>
</script>
<script id="tips-list-template" type="text/x-handlebars-template">
	<div class="tips-list-page">
		{{#each categories}}
			<a href="/#/tips/{{slug}}" class="category">
				<div class="image">
					<img src="{{header_image}}" alt="">
				</div>
				<h3>{{name}}</h3>
				<i class="far text-white fa-chevron-right"></i>
			</a>
		{{/each}}
	</div>
</script>
<script id="tips-detail-template" type="text/x-handlebars-template">
	<div class="tips-detail">
		{{#each tips}}
				<div class="tips accordion">
					<div class="header">
						<div class="message font-normal">{{{description}}}</div>
						<i class="far fa-chevron-down fa-fw text-white arrow"></i>
					</div>
				</div>
		{{/each}}
	</div>
</script>
<script id="product-lightbox-template" type="text/x-handlebars-template">
	<div id="product-lightbox" class="lightbox product hide">
		<div class="dialog">
			<button class="close" onclick="closeProduct()"><i class="fas fa-times-circle"></i></button>
			<div class="header">
				<div class="image">
					<img src="{{thumbnail}}" alt="">
				</div>
				<div class="text">
					<h3 class="text-blue">{{post_title}}</h3>
					<div class="number font-normal">
						Productnummer: {{product_number}}
					</div>
				</div>
			</div>
			<div class="body">
				{{#each risks}}
					{{#if @index}}

					{{else}}
						<div class="wrapper">
							<div class="icon">
								<i class="{{icon}} text-blue"></i>
							</div>
							<div class="description font-normal">
								{{{message}}}
							</div>
						</div>
					{{/if}}
				{{/each}}
				<a href="/#/product/{{post_name}}" data-target="{{post_name}}" data-depth="5" class="btn btn-pink btn-block text-center"><?php _e( 'Meer informatie', 'asvz' ); ?>&nbsp;<i class="fas fa-chevron-right"></i></a>
			</div>
		</div>
	</div> <!-- end of product lightbox -->
</script>
<script id="materials-lightbox-template" type="text/x-handlebars-template">
	<div id="materials-lightbox" class="lightbox materials hide">
		<div class="dialog" data-task-id="{{taskId}}">
			<button class="close" onclick="closeMaterials()"><i class="fas fa-times-circle"></i></button>
			<h3 class="text-white">Checkboxes</h3>
			<div class="list scrollable">
				{{#each materials}}
				<div class="item">
					<div class="image">
						<img src="{{thumbnail}}" alt="">
					</div>
					<div class="right">
						<div class="name font-normal">{{post_title}}</div>
						<button class="check text-blue" data-item-id="{{ID}}">
							{{#if isChecked}}
								<i class="fas fa-check-circle"></i>
							{{else}}
								<i class="fal fa-circle"></i>
							{{/if}}
						</button>
					</div>
				</div>
				{{/each}}
			</div>
			<div class="checked-confirmation" style="display:{{#if isAllChecked}}block{{else}}none{{/if}}">
				<div class="wrapper">
					<div class="icon text-pink">
						<i class="fas fa-clipboard-list-check"></i>
					</div>
					<div class="text">
						{{completeLabel}}
					</div>
				</div>
			</div>
		</div>
	</div> <!-- end of materials lightbox -->
</script>
<script id="wizard-lightbox-template" type="text/x-handlebars-template">
	<div id="wizard-lightbox" class="lightbox wizard hide">
		<div id="wizard-wrapper">
			<div class="dialog" data-task-id={{taskId}} >
				<button class="close" onclick="closeWizard()"><i class="fas fa-times-circle"></i></button>

					<div class="wizard-carousel owl-carousel owl-theme">
						<div class="item">
								{{>wizardIntroTemplate}}
						</div>
						{{#each steps}}
						<div class="item">
								{{>wizardDialogTemplate step=this index=@index}}
						</div>
						{{/each}}
					</div>

				<div class="bottom-wrapper">
					<div class="asvz-wizard owl-carousel owl-theme">
						<div class="owl-nav">
							<button class="" onclick="wizardPrev()"><i class="fas fa-chevron-left"></i></button>
							<button class="" onclick="wizardNext()"><i class="fas fa-chevron-right"></i></button>
						</div>
						<div class="owl-dots text-white font-normal">
							1/{{inc steps.length}}
						</div>
					</div>
					<div class="links">
						<a href="#" class="wizard-begin">First slide</a>
						<a href="#" class="wizard-close" style="display:none">Close wizard</a>
						{{#if nextTask}}
						<a href="/#/category/{{parentCategory}}/{{nextTask}}" class="" data-target="{{nextTask}}" data-depth="3">Next task</a>
						{{/if}}
					</div>
				</div>
			</div>
		</div>
	</div>
</script>
<script id="feedback-lightbox-template" type="text/x-handlebars-template">
	<div id="feedback-lightbox" class="lightbox feedback hide">
		<div class="dialog">
			<button class="close" onclick="closeFeedback()"><i class="fas fa-times-circle"></i></button>
			<div class="title">{{title}}</div>
			<div class="description font-normal">
				{{subtitle}}
			</div>
			<form class="feedback-form" action="/">
				<input type="hidden" name="task-id" value="{{id}}">
				<div class="stars">
					{{#each stars}}
						<input type="radio" id="rating-{{@index}}" name="rating" value="{{@index}}" {{#if this}}checked{{/if}}>
						<label for="rating-{{@index}}"><i class="fas fa-broom text-white"></i></label>
					{{/each}}
				</div>
				<textarea class="font-normal" name="review" id="" placeholder="{{placeholder}}"></textarea>
				<div class="review-invalid">Review is empty</div>
				<input type="submit" class="btn btn-pink btn-block" value="Verstuur">
			</form>
		</div>
	</div>
</script>
<script id="contact-feedback-lightbox-template" type="text/x-handlebars-template">
	<div id="contact-feedback-lightbox" class="lightbox contact-lightbox hide">
		<div class="dialog">
			<button class="close" onclick="closeContactFeedback()"><i class="fas fa-times-circle"></i></button>
			<div class="icon"><i class="fas fa-comment-alt-check"></i></div>
			<div class="title">{{title}}</div>
			<div class="content font-normal">{{{description}}}</div>
			<button class="btn btn-pink btn-block" onclick="closeContactFeedback()"><?php _e( 'Oké!', 'asvz' ); ?></button>
		</div>
	</div>
</script>
<script id="tips-lightbox-template" type="text/x-handlebars-template">
	<div id="tips-lightbox" class="lightbox tips hide">
		<div class="dialog-wrapper">
			<button class="close" onclick="closeTips()"><i class="fas fa-times-circle"></i></button>
			<div class="dialog">
				<div class="title">
					{{title}}
				</div>
				<div class="tips-list">
					{{#each tips}}
						<div class="item">
							<div class="number">{{inc @index}}</div>
							<div class="content font-normal">{{{description}}}</div>
						</div>
					{{/each}}
				</div>
			</div>
		</div>
	</div>
</script>
<script id="wizard-intro-template" type="text/x-handlebars-template">
	<div class="intro font-normal">
		<div class="inner">
			<h2 class="font-thin">{{intro.header}}</h2>
			<div class="body">
				{{{intro.body}}}
			</div>
			<div class="footer">
				{{intro.footer}}
			</div>
		</div>
	</div>
</script>
<script id="wizard-dialog-template" type="text/x-handlebars-template">
	<div class="header">
		<h3 class="text-pink title">{{#if lastSlide}}<span>{{title}}</span>{{else}}Step {{inc index}}{{/if}}</h3>
		<div class="description font-normal">
			{{name}}
		</div>
		{{#if has_warning}}
			<div class="button">
				<button onclick="openProduct({{material}})" disabled><i class="fas fa-exclamation-triangle"></i> Hardcoded label</button>
			</div>
		{{/if}}
	</div>
	<div class="image">
		<img src="{{image}}" alt="">
	</div>
</script>
<script id="float-template" type="text/x-handlebars-template">
	<div class="floating">
	<button class="bg-primary wizard-btn" onclick="{{#if isTasksDetail}}openWizard({{taskId}}){{else}}openTips({{categoryId}}){{/if}}">
		<i class="{{fabIcon}} text-white"></i>
	</button>
	</div>
</script>
<?php
get_footer();
