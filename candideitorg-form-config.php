<div id="message" class="<?php echo $msj_class ?>"><?php echo $msj ?></div>
<div class="wrap">
    <h2>Configuración Candideit.org</h2>
    
    <ul class="pasos">
        <li>Primero debes ingresar tu llave de acceso (API Key) y guardar</li>
    </ul>

    <form method="post" name="elFormulario" action="">
        <?php echo settings_fields('candideit_options'); ?>
        <h3>Configuración General</h3>
        <table class="form-table">
            <tr>
                <th scope="row">Username</th>
                <td>
                    <fieldset>
                        <legend class="screen-reader-text"><span>Username</span></legend>
                        <label for="candideit_username">
                            <input type="text" name="candideit_username" id="candideit_username" value="<?php echo (get_option('candideit_username')) ? get_option('candideit_username') : '' ?>" />
                        </label>
                    </fieldset>
                </td>
            </tr>
            <tr>
                <th scope="row">Código de acceso (API Key)</th>
                <td>
                    <fieldset>
                        <legend class="screen-reader-text"><span>Código de acceso (API Key)</span></legend>
                        <label for="candideit_api_key">
                            <input type="text" name="candideit_api_key" id="candideit_api_key" value="<?php echo (get_option('candideit_api_key')) ? get_option('candideit_api_key') : '' ?>" />
                            <a href="http://candideit.org/accounts/register/">Puedes solicitar tu API Key desde acá</a>
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
                <th scope="row">Elecciones</th>
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
                <th scope="row">Candidatos</th>
                <td>
                    <fieldset>
                        <legend class="screen-reader-text"><span>Candidatos</span></legend>
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