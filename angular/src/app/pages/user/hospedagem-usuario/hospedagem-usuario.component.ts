import { Component, OnInit } from '@angular/core';

@Component({
  selector: 'app-hospedagem-usuario',
  templateUrl: './hospedagem-usuario.component.html',
  styleUrls: ['./hospedagem-usuario.component.css']
})
export class HospedagemUsuarioComponent implements OnInit {

  hotelFoto: string[] = [
    ''
  ]
  imagem: any = '';

  hotel: any[] = [
   {
      idHotel: 'h005',
      nomeHotel: 'Hotel Dominguez Plaza',
      enderecoHotel: 'Av. Beira Mar, 238',
      telefoneHotel: '(21) 3324-4567',
      descricaoHotel: 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec hendrerit auctor nisi, a cursus elit laoreet eu. Nunc felis ante, lacinia in ante at, feugiat convallis ex. '
    },

   {  idHotel: 'h006',
      nomeHotel: 'Hotel Habitare',
      enderecoHotel: 'Vieira Souto, 238',
      telefoneHotel: '(21) 2124-4567',
      descricaoHotel: 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec hendrerit auctor nisi, a cursus elit laoreet eu. Nunc felis ante, lacinia in ante at, feugiat convallis ex. '
   }

  ];
  constructor() { }

  ngOnInit() {
  }


}
