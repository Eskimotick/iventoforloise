import { Component, OnInit } from '@angular/core';

@Component({
  selector: 'app-hospedagem-usuario',
  templateUrl: './hospedagem-usuario.component.html',
  styleUrls: ['./hospedagem-usuario.component.css']
})
export class HospedagemUsuarioComponent implements OnInit {

  hoteis: any[] = [{
    nomeHotel: 'Ibis', 
    enderecoHotel: 'Av. Beira Mar, 238', 
    descricaoHotel: 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec hendrerit auctor nisi, a cursus elit laoreet eu. Nunc felis ante, lacinia in ante at, feugiat convallis ex. ',
  }, []];

  constructor() { }

  ngOnInit() {
  }

}
