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
      nomeHotel: 'Ibis',
      enderecoHotel: 'Av. Beira Mar, 238',
      telefoneHotel: '(21) 3324-4567',
      descricaoHotel: 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec hendrerit auctor nisi, a cursus elit laoreet eu. Nunc felis ante, lacinia in ante at, feugiat convallis ex. '
      /*quarto:
                      [{ tipoQuarto: 'Suite Standard',
                        CapacidadeQuarto: '2', // ex.: 2 pessoas por quarto
                        numQuarto: [102, 103, 104, 105, 106], // numeros dos quartos deste tipo
                        obsQuarto: 'Ar Condicionado, TV, Frigobar, WiFi', //detalhes sobre o quarto, o que inclui: tv, ar condicionado

                      },
                      { tipoQuarto: 'Suite Simples',
                        CapacidadeQuarto: '2',
                        numQuarto: [201, 202, 203, 204, 205, 206, 207],
                        obsQuarto: 'Ventilador, Frigobar, WiFi'

                      }]*/
    },

   {
      nomeHotel: 'Pousada 5',
      enderecoHotel: 'Vieira Souto, 238',
      telefoneHotel: '(21) 2124-4567',
      descricaoHotel: 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec hendrerit auctor nisi, a cursus elit laoreet eu. Nunc felis ante, lacinia in ante at, feugiat convallis ex. '
      /*quarto: [{ tipoQuarto: 'Chalé',
                  CapacidadeQuarto: '4',
                  numQuarto: [16, 18, 21, 22, 23, 30],
                  obsQuarto: 'Ventilador, Frigobar, WiFi'

              }]*/

   }

  ];



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
