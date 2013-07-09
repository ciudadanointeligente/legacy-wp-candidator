<div class="candideitor">
    <div class="container">
        <div class="perfiles row-fluid">
            <div class="span9">
                <div class="row-fluid">
                    <?php
                    $cnt_candidatos = 1;
                    foreach ($aCandidatos as $c) {
                    ?>
                    <div class="span3">
                        <div>
                            <img src="<?php echo ($c->photo) ? $c->photo : 'http://placehold.it/200x200' ?>" width="45" height="45">
                            <h5><a href="#<?php echo $c->slug ?>" data-candidato-slug="<?php echo $c->slug ?>"><?php echo $c->name ?></a></h5>
                        </div>
                    </div>
                    <?php
                        if($cnt_candidatos==3)
                            echo '</div><div class="row-fluid">';

                        if($cnt_candidatos==3)
                            $cnt_candidatos = 1;
                        else
                            $cnt_candidatos++;
                    }
                    ?>
                </div>
            </div>
            <div class="span3">
                <ul>
                    <!--<li>Revisa los perfiles</li>-->
                    <li><a href="#frente-a-frente" class="frente-a-frente">Frente a frente</a></li>
                    <li>Encuentra tu 1/2 naranja</li>
                </ul>
            </div>
        </div>
        <div class="perfil row-fluid">
            <?php
            foreach ($aCandidatos as $c) {
            ?>
            <div id="candidato-<?php echo $c->slug ?>" class="candidato" style="display:none">
                <h5><?php echo $c->name ?></h5>
                <div class="photo-candidato">
                    <img src="<?php echo $c->photo ?>" alt="<?php echo $c->name ?>">
                </div>
                <table class="table-striped">
                    <?php
                    foreach ($c->personal_data as $p) {
                    ?>
                    <tr>
                        <td><?php echo $p->label ?></td>
                        <td><?php echo $p->value ?></td>
                    </tr>
                    <?php
                    }
                    ?>
                </table>
                <div class="redes-candidato">
                    <ul>
                        <?php
                        foreach ($c->links as $l) {
                        ?>
                        <li><a href="<?php echo $l->url ?>" target="_blank"><?php echo $l->name ?></a></li>
                        <?php
                        }
                        ?>
                    </ul>
                </div>
                <table class="">
                    <?php
                    foreach ($c->categories as $categ) {
                        foreach ($categ->questions as $q) {
                    ?>
                    <tr>
                        <td><?php echo $q->question ?></td>
                        <td><?php echo $q->answer->caption ?></td>
                    </tr>
                    <?php
                        }
                    }
                    ?>
                </table>
                <ul>
                    <li><a href="#perfiles" class="volver" data-candidato-slug="<?php echo $c->slug ?>">Revisa los perfiles</a></li>
                    <li><a href="#frente-a-frente" class="frente-a-frente" data-candidato-slug="<?php echo $c->slug ?>">Frente a frente</a></li>
                    <li>Encuentra tu 1/2 naranja</li>
                </ul>
            </div>
            <?php
            }
            ?>
        </div>
        <div id="frente-a-frente" class="row-fluid" style="display:none">
            <div class="span6">
                <ul>
                    <li><a href="#perfiles" class="volver">Revisa los perfiles</a></li>
                    <!--
                    <li><a href="#" class="frente-a-frente" data-candidato-id="<?php echo $c->id ?>">Frente a frente</a></li>
                    <li>Encuentra tu 1/2 naranja</li>
                    -->
                </ul>
            </div>
            <div class="span3">
                <select name="candidato-a" id="candidato-a">
                    <option value="0">Selecciona un candidato</option>
                    <?php
                    foreach ($aCandidatos as $c) {
                    ?>
                    <option value="<?php echo $c->slug ?>"><?php echo $c->name ?></option>
                    <?php
                    }
                    ?>
                </select>
                
                <?php
                foreach ($aCandidatos as $c) {
                ?>
                <div id="candidato-a-vs-slug-<?php echo $c->slug ?>" style="display:none" class="candidato-a-vs">
                    <?php
                    foreach($c->categories as $categ) {
                        ?>
                        <?php echo $categ->name ?>
                        <table class="table-striped">
                        <?php
                        foreach($categ->questions as $question) {
                            ?>
                            <tr>
                                <td class="question"><?php echo $question->question ?></td>
                            </tr>
                            <tr>
                                <td class="answer"><?php echo $question->answer->caption ?></td>
                            </tr>
                            <?php
                        }
                        ?>
                        </table>
                        <?php
                    }
                    ?>
                </div>
                <?php
                }
                ?>
            </div>
            <div class="span3">
                <select name="candidato-b" id="candidato-b">
                    <option value="0">Selecciona un candidato</option>
                    <?php
                    foreach ($aCandidatos as $c) {
                    ?>
                    <option value="<?php echo $c->slug ?>"><?php echo $c->name ?></option>
                    <?php
                    }
                    ?>
                </select>

                <?php
                foreach ($aCandidatos as $c) {
                ?>
                <div id="candidato-b-vs-slug-<?php echo $c->slug ?>" style="display:none" class="candidato-b-vs">
                    <?php
                    foreach($c->categories as $categ) {
                        ?>
                        <?php echo $categ->name ?>
                        <table class="table-striped">
                        <?php
                        foreach($categ->questions as $question) {
                            ?>
                            <tr>
                                <td class="question"><?php echo $question->question ?></td>
                            </tr>
                            <tr>
                                <td class="answer"><?php echo $question->answer->caption ?></td>
                            </tr>
                            <?php
                        }
                        ?>
                        </table>
                        <?php
                    }
                    ?>
                </div>
                <?php
                }
                ?>
            </div>
        </div>
    </div>
</div>
<script>
    jQuery(document).ready(function($) {
        <?php
        foreach ($aCandidatos as $c) 
        {
        ?>
        if(location.hash == '#<?php echo $c->slug ?>') {
            $('.perfiles').attr('style','display:none');
            $('.candidato').attr('style','display:none');
            $('#candidato-<?php echo $c->slug ?>').attr('style', 'display:block');
        }
        <?php
        }
        ?>
    })
</script>