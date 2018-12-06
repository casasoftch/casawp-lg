<?php if (!$state || ($state && $state != "success")): ?>
	<div class="casawp-lg-wrapper" id="clgContactForm" style="display: block;">
		<div class="casawp-lg-wrapper_inner">
			<form id="clgFormAnchor" action="#clgFormAnchor" method="POST" enctype="multipart/form-data">
				<input type="hidden" name="casawplg-inquiry[post]" value="1">
				<?php wp_nonce_field( 'send-inquiry' ); ?>
				<div class="casawp-lg_slide active">
					<div class="row">
						<div class="col-lg-12">
							<div class="casawp-lg_slideinner first_slide">
								<?= do_action('clg_render_contentpart_one', 'clg_render_contentpart_one'); ?>
								<?= do_action('clg_render_home_icons', 'clg_render_home_icons'); ?>
								<?= do_action('clg_render_primary_start_button', 'Loslegen'); ?>
							</div>
						</div>
					</div>
				</div>
				<div class="casawp-lg_slide">
					<div class="row">
						<div class="col-lg-12">
							<div class="casawp-lg_slideinner">
								<div class="casawp-lg_coltitle_outer">
									<div class="row">
										<div class="col-lg-8">
											<?= do_action('clg_render_contentpart_two', 'clg_render_contentpart_two'); ?>
										</div>
										<div class="col-lg-4">
											<div class="casawp-lg_counter">
												<div>
													<span class="casawp-lg_number bg-primary">
														1
													</span>
												</div>
												<div>
													<span class="casawp-lg_number">
														2
													</span>
												</div>
												<div>
													<span class="casawp-lg_number">
														3
													</span>
												</div>
												<div>
													<span class="casawp-lg_number">
														4
													</span>
												</div>
											</div>
										</div>
									</div>
								</div>
								<?= do_action('clg_render_map'); ?>
								<div class="casawp-lg_buttons multi_buttons">
									<?= do_action('clg_render_primary_back_button', 'Zurück'); ?>
									<?= do_action('clg_render_primary_forward_button', 'Weiter'); ?>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="casawp-lg_slide">
					<div class="row">
						<div class="col-lg-12">
							<div class="casawp-lg_slideinner">
								<div class="casawp-lg_coltitle_outer">
									<div class="row">
										<div class="col-lg-8">
											<?= do_action('clg_render_contentpart_three', 'clg_render_contentpart_three'); ?>
										</div>
										<div class="col-lg-4">
											<div class="casawp-lg_counter">
												<div>
													<span class="casawp-lg_number bg-primary">
														1
													</span>
												</div>
												<div>
													<span class="casawp-lg_number bg-primary">
														2
													</span>
												</div>
												<div>
													<span class="casawp-lg_number">
														3
													</span>
												</div>
												<div>
													<span class="casawp-lg_number">
														4
													</span>
												</div>
											</div>
										</div>
									</div>
								</div>
								<?= do_action('clg_render_property_data'); ?>
								<div class="casawp-lg_buttons multi_buttons">
									<?= do_action('clg_render_primary_back_button', 'Zurück'); ?>
									<?= do_action('clg_render_primary_forward_button', 'Weiter'); ?>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="casawp-lg_slide">
					<div class="row">
						<div class="col-lg-12">
							<div class="casawp-lg_slideinner">
								<div class="casawp-lg_coltitle_outer">
									<div class="row">
										<div class="col-lg-8">
											<?= do_action('clg_render_contentpart_four', 'clg_render_contentpart_four'); ?>
										</div>
										<div class="col-lg-4">
											<div class="casawp-lg_counter">
												<div>
													<span class="casawp-lg_number bg-primary">
														1
													</span>
												</div>
												<div>
													<span class="casawp-lg_number bg-primary">
														2
													</span>
												</div>
												<div>
													<span class="casawp-lg_number bg-primary">
														3
													</span>
												</div>
												<div>
													<span class="casawp-lg_number">
														4
													</span>
												</div>
											</div>
										</div>
									</div>
								</div>
								<?= do_action('clg_render_contactform'); ?>
								<div class="casawp-lg_buttons multi_buttons">
									<?= do_action('clg_render_primary_back_button', 'Zurück'); ?>
									<?= do_action('clg_render_primary_submit_button', 'Senden'); ?>
								</div>
							</div>
						</div>
					</div>
				</div>
			</form>
		</div>
	</div>
<?php endif ?>
<?php if ($message): ?>
	<div class="alert alert-<?= $state ?>">
		<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
		<?= $message ?>
	</div>
<?php endif ?>