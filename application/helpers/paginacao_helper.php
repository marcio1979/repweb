<?php

 /* Paginação */
function paginacao($total, $url, $pagina, $limite = 30){
    
    // Define a página
    if (!$pagina) {
        $pagina = 1;
    } else {
        $pagina = $pagina;
    }
        
    // Inicia da linha zero no banco
    $inicio = ($pagina*$limite) - $limite;
    
    // Número de páginas
    $paginas = $total / $limite;
    $paginas = ceil($paginas);
    
    // Botões de navegação
    $volta   = $pagina - 1;
    $proxima = $pagina + 1;
    
    // Texto da paginação
    $paginacao = '<div class="alert alert-warning"><div style="width: 200px; margin: 0 auto; clear: both; color: #000; font-weight: bold;">';
    
    if ($volta > 0){
        $paginacao .= ' <a href="'.$url.'&amp;pag=1" title="Primeira Página"><img src="'.base_url("images/first.gif").'" border="0" align="absbottom"></a>';
        $paginacao .= ' <a href="'.$url.'&amp;pag='.$volta.'" title="Página Anterior"><img src="'.base_url("images/back.gif").'" border="0" align="absbottom"></a>';
    }
    
    $paginacao .= ' Página <select name="pagina" onchange="location.href= \''.$url.'&pag=\' + this.value" class="txtbox">';
    
    // Repete até que as páginas acabem
    for ($i = 1; $i <= $paginas; $i++){ 
        $pag =  $i;
        // Mostra o botão da página
        if($pag == $pagina) { $paginacao .= ' <option selected="selected" value="'.$pag.'">'.$pag.'</option>'; }
        else { $paginacao .= ' <option value="'.$pag.'">'.$pag.'</option>'; }

    }
    
    $paginacao .= ' </select>';
    
    $total = $paginas;
    
    if ($pagina < $total){
        $paginacao .= ' <a href="'.$url.'&amp;pag='.$proxima.'" title="Próxima Página"><img src="'.base_url("images/next.gif").'" border="0" align="absbottom"></a>';
        $paginacao .= ' <a href="'.$url.'&amp;pag='.$total.'" title="Última Página"><img src="'.base_url("images/last.gif").'" border="0" align="absbottom"></a>';
    }

    $paginacao .= '</div></div>';

    if($paginas > 1){
        return array('html' => $paginacao, 'inicio' => $inicio, 'limite' => $limite); 
    }
}
?>