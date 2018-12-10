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
								<?php 
									$html = '<h2>Kostenlose Marktpreiseinschätzung Ihrer Immobilie</h2>
	       									<p>Die Bewertung Ihrer Immobilie ist kostenlos und dauert nur einige Minuten.</p>';
									echo apply_filters('clg_render_contentpart_one', $html);
								?>
								<?php 
									$html = '<div class="casawp-lg_slideinner__icons">
								            <div>
								                <span class="icons_iconouter__first">
								                    <svg width="20px" height="24px" viewBox="0 0 20 24" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
								                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd" stroke-linecap="round" stroke-linejoin="round">
								                            <g class="strokeColor" transform="translate(-605.000000, -521.000000)" stroke="#ffffff">
								                                <g transform="translate(600.000000, 518.000000)">
								                                    <g transform="translate(6.000000, 4.000000)">
								                                        <path d="M17.5263158,9.47368421 C17.5263158,16.1052632 9,22.2631579 9,22.2631579 C9,22.2631579 0.473684211,16.1052632 0.473684211,9.47368421 C0.473684211,4.50378947 4.02915789,0.473684211 9,0.473684211 C13.9698947,0.473684211 17.5263158,4.50378947 17.5263158,9.47368421 L17.5263158,9.47368421 Z"></path>
								                                        <polyline points="6.15789474 8.05263158 6.15789474 12.7894737 11.8421053 12.7894737 11.8421053 8.05263158"></polyline>
								                                        <polygon points="4.26315789 8.05263158 9 3.78947368 13.7368421 8.05263158"></polygon>
								                                        <polygon points="8.05263158 12.7894737 9.94736842 12.7894737 9.94736842 9.94736842 8.05263158 9.94736842"></polygon>
								                                    </g>
								                                </g>
								                            </g>
								                        </g>
								                    </svg>
								                </span>
								            </div>
								            <div>
								                <span class="icons_iconouter__second">
								                    <svg width="20px" height="18px" viewBox="0 0 20 18" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
								                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd" stroke-linejoin="round">
								                            <g class="strokeColor" transform="translate(-675.000000, -524.000000)" stroke="#ffffff">
								                                <g transform="translate(670.000000, 518.000000)">
								                                    <g transform="translate(6.000000, 6.000000)">
								                                        <polyline stroke-linecap="round" points="2.625 9.375 2.625 16.875 15.375 16.875 15.375 9.75"></polyline>
								                                        <polyline stroke-linecap="round" points="0.375 9 9 0.375 17.625 9"></polyline>
								                                        <polyline stroke-linecap="round" points="12 1.125 14.625 1.125 14.625 3.75"></polyline>
								                                        <path d="M12.75,9.832425 C12.75,11.789925 9.585,14.144925 9.2175,14.407425 C9.1575,14.459925 9.075,14.482425 9,14.482425 C8.925,14.482425 8.8425,14.459925 8.7825,14.407425 C8.415,14.144925 5.25,11.789925 5.25,9.832425 C5.25,8.437425 6.2925,7.597425 7.2975,7.597425 C7.875,7.597425 8.55,7.882425 9,8.624925 C9.45,7.882425 10.125,7.597425 10.7025,7.597425 C11.7075,7.597425 12.75,8.437425 12.75,9.832425 L12.75,9.832425 Z"></path>
								                                    </g>
								                                </g>
								                            </g>
								                        </g>
								                    </svg>
								                </span>
								            </div>
								            <div>
								                <span class="icons_iconouter__third">
								                    <svg width="20px" height="20px" viewBox="0 0 20 20" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
								                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd" stroke-linejoin="round">
								                            <g class="strokeColor" transform="translate(-745.000000, -522.000000)" stroke="#ffffff">
								                                <g transform="translate(740.000000, 518.000000)">
								                                    <g transform="translate(6.000000, 5.000000)">
								                                        <path d="M6.75,10.07622 L6.75,12.59982 L2.2419,14.20992 C1.1673,14.59422 0.45,15.61212 0.45,16.75242 L0.45,18.44982 L17.55,18.44982 L17.55,16.75242 C17.55,15.61212 16.8327,14.59422 15.7581,14.20992 L11.25,12.59982 L11.25,10.07622"></path>
								                                        <path d="M13.5,5.4 C13.5,8.3817 11.4849,10.8 9,10.8 C6.5142,10.8 4.5,8.3817 4.5,5.4 C4.5,2.4183 6.5142,0 9,0 C11.4849,0 13.5,2.4183 13.5,5.4 L13.5,5.4 Z"></path>
								                                        <path d="M13.45779,4.90779 C13.30659,4.92669 13.20219,4.92039 13.05009,4.95009 C11.51739,5.24529 10.53279,4.68999 9.68859,3.21309 C9.18279,4.18329 7.59969,4.95009 6.30009,4.95009 C5.66019,4.95009 5.10939,4.81869 4.55769,4.53069"></path>
								                                    </g>
								                                </g>
								                            </g>
								                        </g>
								                    </svg>
								                </span>
								            </div>
								            <div>
								                <span class="icons_iconouter__check">
								                    <svg width="15px" height="13px" viewBox="0 0 15 13" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
								                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
								                            <g class="fillColor" transform="translate(-818.000000, -526.000000)" fill="#ffffff">
								                                <g transform="translate(810.000000, 518.000000)">
								                                    <polygon points="12.765625 17.78125 21.75 8.796875 23 10.0078125 12.765625 20.203125 8 15.4375 9.25 14.2265625"></polygon>
								                                </g>
								                            </g>
								                        </g>
								                    </svg>
								                </span>
								            </div>
								        </div>';
									echo apply_filters('clg_render_home_icons', $html);
								?>
								<?php 
									$html = '<div class="casawp-lg_buttons center_buttons">
									            <a href="#" class="btn btn-primary btn-forward">
									                Loslegen
									            </a>
									        </div>';
									echo apply_filters('clg_render_primary_start_button', $html);
								?>
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
											<?php 
												$html = ' <h2>
												            <svg width="20px" height="24px" viewBox="0 0 20 24" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
												                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd" stroke-linecap="round" stroke-linejoin="round">
												                    <g class="strokeColor" transform="translate(-605.000000, -521.000000)" stroke="#ffffff">
												                        <g transform="translate(600.000000, 518.000000)">
												                            <g transform="translate(6.000000, 4.000000)">
												                                <path d="M17.5263158,9.47368421 C17.5263158,16.1052632 9,22.2631579 9,22.2631579 C9,22.2631579 0.473684211,16.1052632 0.473684211,9.47368421 C0.473684211,4.50378947 4.02915789,0.473684211 9,0.473684211 C13.9698947,0.473684211 17.5263158,4.50378947 17.5263158,9.47368421 L17.5263158,9.47368421 Z"></path>
												                                <polyline points="6.15789474 8.05263158 6.15789474 12.7894737 11.8421053 12.7894737 11.8421053 8.05263158"></polyline>
												                                <polygon points="4.26315789 8.05263158 9 3.78947368 13.7368421 8.05263158"></polygon>
												                                <polygon points="8.05263158 12.7894737 9.94736842 12.7894737 9.94736842 9.94736842 8.05263158 9.94736842"></polygon>
												                            </g>
												                        </g>
												                    </g>
												                </g>
												            </svg> Informationen zum Standort.
												        </h2>';
												echo apply_filters('clg_render_contentpart_two', $html);
											?>
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
								<?php 
									$html = '<div class="casawp-lg_mapwrapper">
									            <div class="casawp-lg_searchboxwrapper" id="pac-card">
									                <h3>'.__('Where is the property located?', 'casawplg').'</h3>
									                <div class="casawp-lg_searchboxinput">
									                    <input id="pac-input" required class="controls" type="text" placeholder="Adresse, Ort, PLZ">
									                </div>
									            </div>
									            <div id="casawp-lg_map"></div>
									            <input required type="hidden" id="countryName" name="extra_data[Land]">
									            <input required type="hidden" id="cityName" name="extra_data[Ort]">
									            <input required type="hidden" id="cityLat" name="extra_data[Lat]">
									            <input required type="hidden" id="cityLng" name="extra_data[Lng]">
									        </div>';
									echo apply_filters('clg_render_map', $html);
								?>
								<div class="casawp-lg_buttons multi_buttons">
									<?php 
										$html = '<a href="#" class="btn btn-primary btn-backward">
										            Zurück
										        </a>';
										echo apply_filters('clg_render_primary_back_button', $html);
									?>
									<?php 
										$html = '<a href="#" class="btn btn-primary btn-forward">
										            Weiter
										        </a>';
										echo apply_filters('clg_render_primary_forward_button', $html);
									?>
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
											<?php 
												$html = '<h2>
											            <svg width="20px" height="18px" viewBox="0 0 20 18" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
											                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd" stroke-linejoin="round">
											                    <g class="strokeColor" transform="translate(-675.000000, -524.000000)" stroke="#ffffff">
											                        <g transform="translate(670.000000, 518.000000)">
											                            <g transform="translate(6.000000, 6.000000)">
											                                <polyline stroke-linecap="round" points="2.625 9.375 2.625 16.875 15.375 16.875 15.375 9.75"></polyline>
											                                <polyline stroke-linecap="round" points="0.375 9 9 0.375 17.625 9"></polyline>
											                                <polyline stroke-linecap="round" points="12 1.125 14.625 1.125 14.625 3.75"></polyline>
											                                <path d="M12.75,9.832425 C12.75,11.789925 9.585,14.144925 9.2175,14.407425 C9.1575,14.459925 9.075,14.482425 9,14.482425 C8.925,14.482425 8.8425,14.459925 8.7825,14.407425 C8.415,14.144925 5.25,11.789925 5.25,9.832425 C5.25,8.437425 6.2925,7.597425 7.2975,7.597425 C7.875,7.597425 8.55,7.882425 9,8.624925 C9.45,7.882425 10.125,7.597425 10.7025,7.597425 C11.7075,7.597425 12.75,8.437425 12.75,9.832425 L12.75,9.832425 Z"></path>
											                            </g>
											                        </g>
											                    </g>
											                </g>
											            </svg> Informationen zu Ihrer Immobilie.
											        </h2>';
												echo apply_filters('clg_render_contentpart_three', $html);
											?>
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
								<?php 
									$html = '<div class="casawp-lg_datawrapper">
									            <div class="casawp-lg_toggle">
									                <label class="casawp-lg_spanlabel control-label">'.__('Property type', 'casawplg').'</label>
									                <div class="casawp-lg_togglebox">
									                    <input type="radio" class="casawp-lg_togglebox__switchinput" name="extra_data[Objektart]" value="Einfamilienhaus" id="casawplgHouse" checked>
									                    <label for="casawplgHouse" class="casawp-lg_togglebox__switchlabel casawp-lg_togglebox__switchlabel-off control-label">'.__('Single-family house', 'casawplg').'</label>
									                    <input type="radio" class="casawp-lg_togglebox__switchinput" name="extra_data[Objektart]" value="Eigentumswohnung" id="casawplgApartment">
									                    <label for="casawplgApartment" class="casawp-lg_togglebox__switchlabel casawp-lg_togglebox__switchlabel-on control-label">'.__('Condominium', 'casawplg').'</label>
									                    <span class="casawp-lg_togglebox__switchselection"></span>
									                </div>
									            </div>
									            <div class="casawp-lg_range">
									                <label class="control-label">'.__('Property surface', 'casawplg').' (m<sup>2</sup>)</label>
									                <input type="range" min="1" max="1500" step="1" value="400" id="casawp-lg-property-surface" name="extra_data[Grundstücksfläche]" data-rangeslider>
									                <div class="clearfix"></div>
									            </div>
									            <div class="casawp-lg_range">
									                <label class="control-label">'.__('Net living area', 'casawplg').' (m<sup>2</sup>)</label>
									                <input type="range" min="1" max="300" step="1" value="100" name="extra_data[Nettowohnfläche]" data-rangeslider>
									                <div class="clearfix"></div>
									            </div>
									            <div class="casawp-lg_range">
									                <label class="control-label">'.__('Number of rooms', 'casawplg').'</label>
									                <input type="range" min="1" max="10" step="0.5" name="extra_data[Anzahl Zimmer]" value="3" data-rangeslider>
									                <div class="clearfix"></div>
									            </div>
									            <div class="casawp-lg_range">
									                <label class="control-label">'.__('Number of bathrooms', 'casawplg').'</label>
									                <input type="range" min="1" max="10" step="1" id="casawp-lg-bathroom" name="extra_data[Anzahl Badezimmer]" value="1" data-rangeslider>
									                <div class="clearfix"></div>
									            </div>
									            <div class="casawp-lg_range">
									                <label class="control-label">'.__('Building year', 'casawplg').'</label>
									                <input type="range" min="' . (date("Y") - 100) . '" max="' . (date("Y") + 4) . '" step="1" value="' . (date("Y") - 20) . '" name="extra_data[Baujahr]" data-rangeslider>
									                <div class="clearfix"></div>
									            </div>
									        </div>';
									echo apply_filters('clg_render_property_data', $html);
								?>
								<div class="casawp-lg_buttons multi_buttons">
									<?php 
										$html = '<a href="#" class="btn btn-primary btn-backward">
										            Zurück
										        </a>';
										echo apply_filters('clg_render_primary_back_button', $html);
									?>
									<?php 
										$html = '<a href="#" class="btn btn-primary btn-forward">
										            Weiter
										        </a>';
										echo apply_filters('clg_render_primary_forward_button', $html);
									?>
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
											<?php 
												$html = '<h2>
										            <svg width="20px" height="20px" viewBox="0 0 20 20" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
										                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd" stroke-linejoin="round">
										                    <g class="strokeColor" transform="translate(-745.000000, -522.000000)" stroke="#ffffff">
										                        <g transform="translate(740.000000, 518.000000)">
										                            <g transform="translate(6.000000, 5.000000)">
										                                <path d="M6.75,10.07622 L6.75,12.59982 L2.2419,14.20992 C1.1673,14.59422 0.45,15.61212 0.45,16.75242 L0.45,18.44982 L17.55,18.44982 L17.55,16.75242 C17.55,15.61212 16.8327,14.59422 15.7581,14.20992 L11.25,12.59982 L11.25,10.07622"></path>
										                                <path d="M13.5,5.4 C13.5,8.3817 11.4849,10.8 9,10.8 C6.5142,10.8 4.5,8.3817 4.5,5.4 C4.5,2.4183 6.5142,0 9,0 C11.4849,0 13.5,2.4183 13.5,5.4 L13.5,5.4 Z"></path>
										                                <path d="M13.45779,4.90779 C13.30659,4.92669 13.20219,4.92039 13.05009,4.95009 C11.51739,5.24529 10.53279,4.68999 9.68859,3.21309 C9.18279,4.18329 7.59969,4.95009 6.30009,4.95009 C5.66019,4.95009 5.10939,4.81869 4.55769,4.53069"></path>
										                            </g>
										                        </g>
										                    </g>
										                </g>
										            </svg> Informationen zu Ihrer Person.
										        </h2>';

												echo apply_filters('clg_render_contentpart_four', $html);
											?>
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
								<?php 
									$html = '<div class="casawp-lg_contactform">
									            <div class="form-group">
									                <div class="casawp-lg_toggle">
									                    <label class="casawp-lg_spanlabel control-label">'.__('Salutation', 'casawplg').'</label>
									                    <div class="casawp-lg_togglebox">
									                        <input type="radio" class="casawp-lg_togglebox__switchinput" name="casawplg-inquiry[gender]" value="Frau" id="casawp-lg-gender_woman" checked>
									                        <label for="casawp-lg-gender_woman" class="casawp-lg_togglebox__switchlabel casawp-lg_togglebox__switchlabel-off control-label">Frau</label>
									                        <input type="radio" class="casawp-lg_togglebox__switchinput" name="casawplg-inquiry[gender]" value="Herr" id="casawp-lg-gender_man">
									                        <label for="casawp-lg-gender_man" class="casawp-lg_togglebox__switchlabel casawp-lg_togglebox__switchlabel-on control-label">Herr</label>
									                        <span class="casawp-lg_togglebox__switchselection"></span>
									                    </div>
									                </div>
									            </div>
									            <div class="row">
									                <div class="col-lg-6">
									                    <div class="form-group">
									                        <label for="casawp-lg_firstname" class="control-label">'.__('First name', 'casawplg').'<sup>*</sup></label>
									                        <input type="text" class="form-control" required id="casawp-lg_firstname" name="casawplg-inquiry[first_name]">
									                    </div>
									                </div>
									                <div class="col-lg-6">
									                    <div class="form-group">
									                        <label for="casawp-lg_lastname" class="control-label">'.__('Last name', 'casawplg').'<sup>*</sup></label>
									                        <input type="text" class="form-control" required id="casawp-lg_lastname" name="casawplg-inquiry[last_name]">
									                    </div>
									                </div>
									            </div>
									            <div class="row">
									                <div class="col-lg-6">
									                    <div class="form-group">
									                        <label for="casawp-lg_mail" class="control-label">'.__('Email', 'casawplg').'<sup>*</sup></label>
									                        <input type="text" class="form-control" required id="casawp-lg_mail" name="casawplg-inquiry[email]">
									                    </div>
									                </div>
									                <div class="col-lg-6">
									                    <div class="form-group">
									                        <label for="casawp-lg_mobile" class="control-label">'.__('Mobile', 'casawplg').'</label>
									                        <input type="text" class="form-control" id="casawp-lg_mobile" name="casawplg-inquiry[mobile]">
									                    </div>
									                </div>
									            </div>
									            <div class="row">
									                <div class="col-lg-12">
									                    <div class="form-group">
									                   		<label class="control-label">'.__('Estimation reason', 'casawplg').'</label>
									                    	<div class="casawp-lg_custom-choices">
										                        <div class="casawp-lg-checkboxoption">
										                        	<input
										                        		tabindex="0"
										                        		id="choice_sell"
										                        		type="checkbox"
										                        		name="extra_data[' . __('Sell', 'casawplg') . ']"
										                        		value="Ja"
										                        	/>
										                        	<label class="control-label" for="choice_sell">' . __('Sell', 'casawplg') . '</label>
										                        </div>
										                        <div class="casawp-lg-checkboxoption">
										                        	<input
										                        		tabindex="0"
										                        		id="choice_buy"
										                        		type="checkbox"
										                        		name="extra_data[' . __('Buy', 'casawplg') . ']"
										                        		value="Ja"
										                        	/>
										                        	<label class="control-label" for="choice_buy">' . __('Buy', 'casawplg') . '</label>
										                        </div>
										                        <div class="casawp-lg-checkboxoption">
										                        	<input
										                        		tabindex="0"
										                        		id="choice_financing"
										                        		type="checkbox"
										                        		name="extra_data[' . __('Financing', 'casawplg') . ']"
										                        		value="Ja"
										                        	/>
										                        	<label class="control-label" for="choice_financing">' . __('Financing', 'casawplg') . '</label>
										                        </div>
										                        <div class="casawp-lg-checkboxoption">
										                        	<input
										                        		tabindex="0"
										                        		id="choice_other"
										                        		type="checkbox"
										                        		name="extra_data[' . __('Other', 'casawplg') . ']"
										                        		value="Ja"
										                        	/>
										                        	<label class="control-label" for="choice_other">' . __('Other', 'casawplg') . '</label>
										                        </div>
									                        </div>
									                    </div>
									                </div>
									            </div>
									        </div>';
									echo apply_filters('clg_render_contactform', $html);
								?>

								<div class="casawp-lg_buttons multi_buttons">
									<?php 
										$html = '<a href="#" class="btn btn-primary btn-backward">
										            Zurück
										        </a>';
										echo apply_filters('clg_render_primary_back_button', $html);
									?>
									<?php 
										$html = ' <button class="btn btn-primary" type="submit">
										           Senden
										        </button>';
										echo apply_filters('clg_render_primary_submit_button', $html);
									?>
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
	<div class="casawp-lg-wrapper casawp-lg-sent" id="clgContactForm" style="display: block;">
		<div class="casawp-lg-wrapper_inner">
			<form id="clgFormAnchor" action="#clgFormAnchor" method="POST" enctype="multipart/form-data">
				<div class="casawp-lg_slide">
					<div class="row">
						<div class="col-lg-12">
							<div class="casawp-lg_slideinner">
								<div class="casawp-lg_coltitle_outer">
									<div class="row">
										<div class="col-lg-8">
											
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
													<span class="casawp-lg_number bg-primary">
														4
													</span>
												</div>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-lg-12">
											<div class="casawp_centerslide">
												<?php 
													$html = '<h2>Die Bewertung wurde erfolgreich abgeschlossen</h2>
							       							<p>Sie werden in Kürze Ihre Bewertungsinformationen per E-Mail erhalten.</p>';
													echo apply_filters('clg_render_sentmessage', $html);
												?>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</form>
		</div>
	</div>
<?php endif ?>