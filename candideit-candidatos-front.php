<div class="candideitor">
    <div class="container">
        <h4>Candidatos</h4>
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
                            <h5><?php echo $c->name ?></h5>
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
                    <li>Revisa los perfiles</li>
                    <li>Frente a frente</li>
                    <li>Encuentra tu 1/2 naranja</li>
                </ul>
            </div>
        </div>
        <div class="face-to-face row-fluid">
            <div class="span4">
                <select name="candidato_a" id="candidato_a">
                    <option value="0">Selecciona un candidato</option>
                    <?php
                    foreach ($aCandidatos as $c) {
                    ?>
                    <option value="<?php echo $c->id ?>"><?php echo $c->name ?></option>
                    <?php
                    }
                    ?>
                </select>
                <?php
                foreach ($aCandidatos as $c) {
                ?>
                <div id="candidato_a_<?php echo $c->id ?>" class="row-fluid cand_a" style="display:none">
                    <div class="span9">
                        <ul>
                            <?php
                            foreach ($c->personal_data as $p) {
                            ?>
                            <li><strong><?php echo $p->label ?></strong> <?php echo $p->value ?></li>
                            <?php
                            }
                            ?>
                        </ul>
                    </div>
                    <div class="span3">
                        <img src="<?php echo ($c->photo) ? $c->photo : 'http://placehold.it/100x100' ?>" width="100" height="100">
                    </div>
                </div>
                <?php
                }
                ?>
            </div>
            <div class="span4">
                <select name="candidato_b" id="candidato_b">
                    <option value="0">Selecciona un candidato</option>
                    <?php
                    foreach ($aCandidatos as $c) {
                    ?>
                    <option value="<?php echo $c->id ?>"><?php echo $c->name ?></option>
                    <?php
                    }
                    ?>
                </select>
                <?php
                foreach ($aCandidatos as $c) {
                ?>
                <div id="candidato_b_<?php echo $c->id ?>" class="row-fluid cand_b" style="display:none">
                    <div class="span9">
                        <ul>
                            <?php
                            foreach ($c->personal_data as $p) {
                            ?>
                            <li><strong><?php echo $p->label ?></strong> <?php echo $p->value ?></li>
                            <?php
                            }
                            ?>
                        </ul>
                    </div>
                    <div class="span3">
                        <img src="<?php echo ($c->photo) ? $c->photo : 'http://placehold.it/100x100' ?>" width="100" height="100">
                    </div>
                </div>
                <?php
                }
                ?>
            </div>
            <div class="span4">
                <h6>Comparando en categoría</h6>
                <ul>
                    <?php
                    foreach ($aCandidatos[0]->categories as $categ) {
                    ?>
                    <li class="inline"><label for="category_<?php echo $categ->id ?>"><input type="radio" name="category" value="<?php echo $categ->id ?>" id="category_<?php echo $categ->id ?>"> <?php echo $categ->name ?></label></li>
                    <?php
                    }
                    ?>
                </ul>
            </div>
        </div>
        
        <?php
        foreach ($aCandidatos[0]->categories as $categ) {
        ?>
        <div style="display:none" class="row-fluid category_id_<?php echo $categ->id ?>">
            <?php
            foreach($categ->questions as $q) {
            ?>
            <div id="question_id_<?php echo $q->id ?>">
                <?php echo $q->question ?>
            </div>
            <?php
            }
            ?>
        </div>
        <?php
        }
        ?>
        
        <?php
        
        foreach ($aCandidatos as $c) {
            foreach ($c->categories as $categorie) {
                foreach ($categorie->questions as $question) {
                    ?>
                    <div style="display:none" id="category_id_<?php echo $categorie->id ?>_candidate_id_<?php echo $c->id ?>">
                        <?php echo ($question->answer->caption!=null) ? $question->answer->caption : 'No ha respondido'; ?>
                    </div>
                    <?php
                }
            }
        }

        echo '<pre>';
        //print_r($aElections);
        echo '</pre>';
        
        ?>
        
    </div>
</div>
<!--
<div class="candidator_org">
    <h4>Candidatos</h4>
    <div class="container">
        <?php
        foreach ($aCandidatos as $c) {
            ?>
            <div class="candidate">
                <img src="<?php echo ($c->photo) ? $c->photo : 'http://placehold.it/200x200' ?>" width="45" height="45">
                
                <h4><?php echo $c->name ?></h4>
                <div>
                    <fieldset>
                        <input data-candidate-name="<?php echo $c->name ?>" type="checkbox" name="candidato-<?php echo $c->id ?>" id="candidato-<?php echo $c->id ?>" value="<?php echo $c->id ?>"> 
                        <label for="candidato-<?php echo $c->id ?>"> Comparar</label>
                    </fieldset>
                </div>
                
                <div style="display:none">
                    <table>
                        <tr>
                            <th colspan="2">Antecedentes personales</th>
                        </tr>
                    <?php
                    foreach ($c->personal_data as $p) {
                        ?>
                        <tr>
                            <td><strong><?php echo $p->label ?></strong></td>
                            <td><?php echo $p->value ?></td>
                        </tr>
                        <?php
                    }
                    ?>
                    </table>    
                </div>
    
            </div>

            <?php
        }
        ?>
    </div>

    <?php
        foreach ($aCandidatos as $c) {
            ?>
    <div class="details-candidate">
        
        <div id="candidato-antecedentes-<?php echo $c->id ?>" style="display:none">
            <table>
                <tr>
                    <th colspan="2">Otros antecedentes</th>
                </tr>
                <?php
                foreach($c->backgrounds as $b) {
                    ?>
                    <tr>
                        <td><strong><?php echo $b->name ?></strong></td>
                        <td><?php echo ($b->value) ? $b->value : 'sin información' ?></td>
                    </tr>
                    <?php
                }
                ?>
            </table>
        </div>
        
        <div id="candidato-pregresp-<?php echo $c->id ?>" style="display:none">
            <table>
                <?php
                foreach ($c->categories as $categ) {
                    ?>
                <thead>
                    <tr>
                        <th colspan="2" class="categ-title"><?php echo $categ->name ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach($categ->questions as $q) {
                    ?>
                    <tr>
                        <td><strong><?php echo $q->question ?></strong></td>
                        <td><?php echo ($q->answer->caption!=null) ? $q->answer->caption : 'No ha respondido'; ?></td>
                    </tr>
                    <?php
                    }
                    ?>
                </tbody>
                <?php
                }
                ?>
            </table>
        </div>
        
    </div>
    <?php
        }
        ?>
       
</div>
-->