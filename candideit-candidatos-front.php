<div class="candidator_org">
    <h4>Candidatos</h4>
    <div class="compare">
        <ul></ul>
    </div>
    <div class="container">
        <?php
        foreach ($aCandidatos as $c) {
            ?>
            <div class="candidate">
                <img src="<?php echo ($c->photo) ? 'http://127.0.0.1:8000'.$c->photo : 'http://placehold.it/200x200' ?>" width="100" height="100">
                
                <h3><?php echo $c->name ?></h3>
                <div>
                    <fieldset>
                        <input data-candidate-name="<?php echo $c->name ?>" type="checkbox" name="candidato-<?php echo $c->id ?>" id="candidato-<?php echo $c->id ?>" value="<?php echo $c->id ?>"> 
                        <label for="candidato-<?php echo $c->id ?>"> Comparar</label>
                    </fieldset>
                </div>
                <!--
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
                -->
            </div>
            <?php
        }
        ?>
    </div>
</div>