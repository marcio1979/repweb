<?php
defined('BASEPATH') OR exit('No direct script access allowed');
        
Class M_produtos extends CI_Model
{
    
    public function total ($filtros) {
        $result = $this->listar($filtros);
        return count($result);
    }
    
    public function listar ($filtros, $ordem = null, $sort = null, $inicio = null, $limite = null)
    {
        $this->db->select('produtos.ProdCod, ProdNome, ProdDescricao, ProdTipoMarcador, ProdMarcador, ProdFoto, ProdCodigoInterno, PGNome, produtos.ForCod, ForNome, FabNome, produtos.FabCod, produtos.PGCod, ProdValor, ProdDataCadastro, ProdAtivo, ProdExcluido');
        $this->db->from('produtos');
        $this->db->join('produtosgrupos', 'produtosgrupos.PGCod = produtos.PGCod', 'left');
        $this->db->join('fornecedores', 'fornecedores.ForCod = produtos.ForCod', 'left');
        $this->db->join('fabricantes', 'fabricantes.FabCod = produtos.FabCod', 'left');
        
        if (isset($inicio) && isset($limite)) {
            $this->db->limit($limite, $inicio);        
        }
        
        if (isset($ordem) && isset($sort)) {
            $this->db->order_by($ordem, $sort);
        }
        
        foreach ($filtros as $dado => $filtro) { 
            if ($filtro != '') { 
                if ($dado == 'ProdAtivo' || $dado == 'ProdExcluido') { 
                    if ($filtro == 0 || $filtro == 1) {
                        $this->db->where($dado, $filtro);
                    }
                } elseif ($dado == 'PGCod' || $dado == 'ForCod' || $dado == 'ProdCod' || $dado == 'FabCod') {
                    $this->db->where('produtos.'.$dado, $filtro);
                } else {
                    $this->db->like($dado, $filtro);
                }
            }
        }
        
        $query = $this->db->get(); 
        return $query->result();
    }

    public function excluir ($codigo) {
        $this->db->where('ProdCod', $codigo);
        $this->db->update('produtos', array('ProdExcluido' => '1'));
        return true;
    }
    
    public function alterar ($dados)
    {
        $this->db->where('ProdCod', $dados['ProdCod']);
        $this->db->update('produtos', $dados);
        return true;
    }
    
    public function cadastrar ($data) {
        $_prepared = array();
        foreach ($data as $col => $val)
            $_prepared[$col] = $this->db->escape($val);
        $this->db->query('INSERT IGNORE INTO produtos ('.implode(',',array_keys($_prepared)).') VALUES('.implode(',',array_values($_prepared)).') ON DUPLICATE KEY UPDATE ProdAtivo = 1, ProdExcluido = 0, ProdValor = \''.$data["ProdValor"].'\', ProdDataUpdate = \''.date('Y-m-d H:i:s').'\';');
        return $this->db->insert_id();
    }
    
    public function fornecedor ($ForCod)
    {
        $this->db->select('produtos.ProdCod, ProdNome, ProdCodigoInterno, ForNome, FabNome, PGNome, ProdValor');
        $this->db->from('produtos');
        $this->db->join('produtosgrupos', 'produtos.PGCod = produtosgrupos.PGCod', 'left');
        $this->db->join('fornecedores', 'fornecedores.ForCod = produtos.ForCod', 'left');
        $this->db->join('fabricantes', 'fabricantes.FabCod = produtos.FabCod', 'left');
        $this->db->where('produtos.ForCod', $ForCod);
        $this->db->where('ProdExcluido', '0');
        $this->db->where('ProdAtivo', '1');
        $this->db->where('ForExcluido', '0');
        $this->db->where('ForAtivo', '1');
        $this->db->where('FabExcluido', '0');
        $this->db->where('FabAtivo', '1');
        $this->db->order_by('FabNome, ForNome, ProdNome', 'ASC');
        
        $query = $this->db->get(); 
        return $query->result();
    }
    
    public function exportar ($ForCod)
    {
        $this->db->select('ProdCodigoInterno, ForNome, FabNome, ProdNome, PGNome, ProdValor');
        $this->db->from('produtos');
        $this->db->join('produtosgrupos', 'produtos.PGCod = produtosgrupos.PGCod', 'left');
        $this->db->join('fornecedores', 'fornecedores.ForCod = produtos.ForCod', 'left');
        $this->db->join('fabricantes', 'fabricantes.FabCod = produtos.FabCod', 'left');
        $this->db->where('produtos.ForCod', $ForCod);
        $this->db->where('ProdExcluido', '0');
        $this->db->where('ProdAtivo', '1');
        $this->db->where('ForExcluido', '0');
        $this->db->where('ForAtivo', '1');
        $this->db->where('FabExcluido', '0');
        $this->db->where('FabAtivo', '1');
        $this->db->order_by('FabNome, ForNome, ProdNome', 'ASC');
        
        $query = $this->db->get(); 
        return $query->result();
    }
   
}