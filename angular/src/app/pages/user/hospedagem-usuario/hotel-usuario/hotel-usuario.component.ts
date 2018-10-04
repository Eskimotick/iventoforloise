import { Component, OnInit, Input, Output, EventEmitter  } from '@angular/core';



@Component({
  selector: 'app-hotel-usuario',
  templateUrl: './hotel-usuario.component.html',
  styleUrls: ['./hotel-usuario.component.css']
})
export class HotelUsuarioComponent implements OnInit {

  @Input('hotel') hotel: any[];
  @Input('hotelFoto') hotelFoto: string;
  @Input('quarto') quarto: any[];


  hotel: Array<any> = [
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

  quarto: Array<any> = [
    { idHotel: 'h005',
      tipoQuarto: 'Suite Standard',
      CapacidadeQuarto: '2', // ex.: 2 pessoas por quarto
      numQuarto: [102, 103, 104, 105, 106], // numeros dos quartos deste tipo
      obsQuarto: 'Ar Condicionado, TV, Frigobar, WiFi' //detalhes sobre o quarto, o que inclui: tv, ar condicionado

    },
    { idHotel: 'h005',
      tipoQuarto: 'Suite Simples',
      CapacidadeQuarto: '2',
      numQuarto: [201, 202, 203, 204, 205, 206, 207],
      obsQuarto: 'Ventilador, Frigobar, WiFi'

    },
    { idHotel: 'h006',
      tipoQuarto: 'Chalé',
      CapacidadeQuarto: '4',
      numQuarto: [16, 18, 21, 22, 23, 30],
      obsQuarto: 'Ventilador, Frigobar, WiFi'

    }
  ]

  pacotes: string[] = [
    'Pacote Standard', 'Pacote Master', 'Pacote Simples'
  ]

  /*public calculaVagas() : number {
    vagasIniciais = (quarto.length) * (hotel[i].numQuarto.length);
    vagasRestantes = vagasIniciais - vagasOcupadas;

    return vagasRestantes;

  } */



  constructor() { }

  ngOnInit() {
  }

}
