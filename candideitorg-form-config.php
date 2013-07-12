<div id="message" class="<?php echo $msj_class ?>"><?php echo $msj ?></div>
<div class="wrap">
    <h2><?php _e( 'Configuration', 'candideitorg' ) ?> Candideit.org</h2>
    
    <ol class="pasos">
        <li><?php _e( 'You need insert your Username and your API KEY and then press Save Changes', 'candideitorg') ?></li>
        <li><?php _e( 'Choose and Election and then press Save Changes', 'candideitorg') ?></li>
    </ol>

    <form method="post" name="elFormulario" action="">
        <?php echo settings_fields('candideit_options'); ?>
        <h3><?php _e( 'General Configuration', 'candideitorg-general-configuration') ?></h3>
        <table class="form-table">
            <tr>
                <th scope="row"><?php _e( 'Username', 'candideitorg-username') ?></th>
                <td>
                    <fieldset>
                        <legend class="screen-reader-text"><span><?php _e( 'Username', 'candideitorg') ?></span></legend>
                        <label for="candideit_username">
                            <input type="text" name="candideit_username" id="candideit_username" value="<?php echo (get_option('candideit_username')) ? get_option('candideit_username') : '' ?>" />
                        </label>
                    </fieldset>
                </td>
            </tr>
            <tr>
                <th scope="row"><?php _e( 'API Key', 'candideitorg-api-key') ?></th>
                <td>
                    <fieldset>
                        <legend class="screen-reader-text"><span><?php _e( 'API Key', 'candideitorg') ?> (API Key)</span></legend>
                        <label for="candideit_api_key">
                            <input type="text" name="candideit_api_key" id="candideit_api_key" value="<?php echo (get_option('candideit_api_key')) ? get_option('candideit_api_key') : '' ?>" />
                            <a href="http://candideit.org/accounts/register/"><?php _e( 'You can create and API Key from here', 'candideitorg') ?></a>
                        </label>
                    </fieldset>
                </td>
            </tr>
            <?php
            if (get_option('candideit_api_key') && get_option('candideit_username')) 
            {
                $params = array( 
                    'username' => get_option('candideit_username'),
                    'api_key' => get_option('candideit_api_key')
                    );

                $aData = getElecciones($params);
                $Elecciones = $aData->objects;
            ?>
            <tr>
                <th scope="row"><?php _e( 'Elections', 'candideitorg') ?></th>
                <td>
                    <ul>
                        <?php
                        foreach($Elecciones as $e) 
                        {
                            if($e->published) {
                            $selected = ( get_option('candideit_election_id')==$e->id ) ? 'checked="checked"' : '' ;
                        ?>
                        <li>
                            <input type="radio" name="candideit_election_id" id="e<?php echo $e->id ?>" value="<?php echo $e->id ?>" <?php echo $selected ?>> <label for="e<?php echo $e->id ?>"><?php echo $e->name ?></label>
                            <!-- 
                            <img src="<?php echo $e->logo ?>" alt="<?php echo $e->name ?>" height="80" width="80">
                            -->
                        </li>
                        <?php
                            }
                        }
                        ?>
                    </ul>
                </td>
            </tr>
            <?php    
                if(get_option('candideit_election_id')) 
                {
                    $params['election_id'] = get_option('candideit_election_id');
                    $aData = getCandidatos($params);
                    $Candidatos = $aData->candidates;
            ?>
            <tr>
                <th scope="row"><?php _e( 'Candidates', 'candideitorg-candidates') ?></th>
                <td>
                    <fieldset>
                        <legend class="screen-reader-text"><span><?php _e( 'Candidates', 'candideitorg-candidates') ?></span></legend>
                        <label for="cha_servicios">
                            <ul>
                                <?php
                                foreach( $Candidatos as $c ) 
                                {
                                    $selected = '';
                                ?>
                                <li><?php echo $c->id ?>, <?php echo $c->name ?></li>
                                <?php
                                }
                                ?>
                            </ul>
                        </label>
                    </fieldset>
                </td>
            </tr>
            <?php
                }
            }
            ?>
        </table>
        <?php submit_button(); ?>
        <input type="hidden" name="candideit_update" value="true" />
    </form>
</div>