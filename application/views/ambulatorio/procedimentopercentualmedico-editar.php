
<div class="content"> <!-- Inicio da DIV content -->
    <div class="bt_link_voltar">
        <a href="<?= base_url() ?>ambulatorio/procedimentoplano/procedimentopercentual">
            Voltar
        </a>

    </div>
    <div id="accordion">
        <h3 class="singular"><a href="#">Manter Procedimento Honor&aacute;rios M&eacute;dicos</a></h3>
        <div>
            <table>
                <thead>
                    <tr>
                        <th colspan="5" class="tabela_title">
                    </tr>
                <form method="post" action="<?= base_url() ?>ambulatorio/procedimentoplano/editarprocedimento/<?= $dados; ?>">
                    <tr>
                        <th class="tabela_title">Medico</th>  
                        <th class="tabela_title" width="10px;" >Valor</th>
                        <th class="tabela_title" >Procedimento</th>                         
                        <th class="tabela_title" width="10px;">Conv&ecirc;nio</th>
                        
                    </tr>
                    <tr>
                        <th class="tabela_title">
                            <input type="text" name="medico" class="texto04" value="<?php echo @$_POST['medico']; ?>" />
                        </th>
                        <th class="tabela_title">
                            <input type="text" name="valor" class="texto02" value="<?php echo @$_POST['valor']; ?>" />
                        </th>
                        <th class="tabela_title">
                            <input type="text" name="procedimento" class="texto05" value="<?php echo @$_POST['procedimento']; ?>" />
                        </th>
                        <th class="tabela_title">
                            <input type="text" name="convenio" class="texto03" value="<?php echo @$_POST['convenio']; ?>" />
                        </th>
                        <th class="tabela_title">
                            <button type="submit" id="enviar">Pesquisar</button>
                        </th>
                    </tr>
                </form>

                </thead>
            </table>
            <table>
                <thead>
                    <tr>
                        <th class="tabela_header">Medico</th>
                        <th class="tabela_header" width="40px;">Valor</th>
                        <td class="tabela_header" width="90px;"></td>
                        <th class="tabela_header">Procedimento</th>
                        <td class="tabela_header" width="150px;"></td>
                        <th class="tabela_header">Conv&ecirc;nio</th>
                        <td class="tabela_header" width="100px;"></td>
                        <th class="tabela_header" colspan="2">Detalhes</th>
                    </tr>
                </thead>
                <?php
                $url = $this->utilitario->build_query_params(current_url(), $_GET);
                $consulta = $this->procedimentoplano->listarmedicopercentual($dados);
                $total = $consulta->count_all_results();
                $limit = 10;
                isset($_GET['per_page']) ? $pagina = $_GET['per_page'] : $pagina = 0;

                if ($total > 0) {
                    ?>
                    <tbody>
                        <?php                                                     
                        $lista = $this->procedimentoplano->listarmedicopercentual($dados)->orderby('o.nome')->orderby('pt.nome')->limit($limit, $pagina)->get()->result();
                        $estilo_linha = "tabela_content01";
                        foreach ($lista as $item) {
                            ($estilo_linha == "tabela_content01") ? $estilo_linha = "tabela_content02" : $estilo_linha = "tabela_content01";
                            ?>
                            <tr>
                                <td class="<?php echo $estilo_linha; ?>"><?= $item->medico; ?></td>
                                
                                <?php
                                $percentual = $item->percentual;
                                if ($percentual == "t") {
                                    ?>
                                    <td class="<?php echo $estilo_linha; ?>"><?= $item->valor; ?>%</td>
                                <? } elseif ($percentual == "f") { ?>
                                    <td class="<?php echo $estilo_linha; ?>">R$&nbsp;<?= $item->valor; ?></td>
        <? } ?> 
                                <td class="<?php echo $estilo_linha; ?>" ></td>    
                                <td class="<?php echo $estilo_linha; ?>"><?= $item->procedimento; ?></td>
                                <td class="<?php echo $estilo_linha; ?>"></td>
                                <td class="<?php echo $estilo_linha; ?>"><?= $item->convenio; ?></td>
                                <td class="<?php echo $estilo_linha; ?>" ></td>                                
                                <td class="<?php echo $estilo_linha; ?>" width="45px;">
                                    <a onclick="javascript: return confirm('Deseja realmente excluir o procedimento');"
                                       href="<?= base_url() ?>ambulatorio/procedimentoplano/excluirmedicopercentual/<?= $item->procedimento_percentual_medico_convenio_id; ?>">Excluir
                                    </a>
                                </td>
                            </tr>

                        </tbody>
                        <?php
                    }
                }
                ?>

                <tfoot>
                    <tr>
                        <th class="tabela_footer" colspan="8">
<?php $this->utilitario->paginacao($url, $total, $pagina, $limit); ?>
                            Total de registros: <?php echo $total; ?>
                        </th>
                    </tr>
                </tfoot>
            </table>
        </div>       
    </div>
</div> <!-- Final da DIV content -->
<script type="text/javascript">

    $(function () {
        $("#accordion").accordion();
    });

</script>