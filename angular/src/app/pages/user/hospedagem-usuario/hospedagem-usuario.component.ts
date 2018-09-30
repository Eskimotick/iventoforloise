import { Component, OnInit } from '@angular/core';

@Component({
  selector: 'app-hospedagem-usuario',
  templateUrl: './hospedagem-usuario.component.html',
  styleUrls: ['./hospedagem-usuario.component.css']
})
export class HospedagemUsuarioComponent implements OnInit {

  hotel: any[] = [{
    nomeHotel: 'Ibis',
    enderecoHotel: 'Av. Beira Mar, 238',
    descricaoHotel: 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec hendrerit auctor nisi, a cursus elit laoreet eu. Nunc felis ante, lacinia in ante at, feugiat convallis ex. ',

  }];

  quarto: any[] = [{
    tipoQuarto: 'Suite Standard',
    CapacidadeQuarto: '2',
    numeroQuarto: '101'
  }]

  /*hoteis: any[] = [
    {
      nomeHotel: 'Ibis',
      enderecoHotel: 'Av. Beira Mar, 238',
      descricaoHotel: 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec hendrerit auctor nisi, a cursus elit laoreet eu. Nunc felis ante, lacinia in ante at, feugiat convallis ex. ',
      fotoHotel: '',
    },
    {
      nomeHotel: 'Sheraton',
      enderecoHotel: 'Av. Beira Mar, 238',
      descricaoHotel: 'Donec hendrerit auctor nisi, a cursus elit laoreet eu. Nunc felis ante, lacinia in ante at, feugiat convallis ex. ',
      fotoHotel: ''

    }
  ] */

  constructor() { }

  ngOnInit() {
  }


}
