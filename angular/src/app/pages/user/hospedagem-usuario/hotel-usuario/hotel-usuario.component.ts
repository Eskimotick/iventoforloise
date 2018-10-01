import { Component, OnInit, Input  } from '@angular/core';
import { Output, EventEmitter} from '@angular/core';

@Component({
  selector: 'app-hotel-usuario',
  templateUrl: './hotel-usuario.component.html',
  styleUrls: ['./hotel-usuario.component.css']
})
export class HotelUsuarioComponent implements OnInit {

  @Input('hotel') hotel: any;
  @Input('hotelFoto') hotelFoto: string;

  /*hotel: Array<any> = [{
    nomeHotel: 'Ibis',
    enderecoHotel: 'Av. Beira Mar, 238',
    descricaoHotel: 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec hendrerit auctor nisi, a cursus elit laoreet eu. Nunc felis ante, lacinia in ante at, feugiat convallis ex. ',
  }];*/

  quarto: Array<any> = [
    { tipoQuarto: 'Suite Standard',
      CapacidadeQuarto: '2', // ex.: 2 pessoas por quarto
      numQuarto: [102, 103, 104, 105, 106], // numeros dos quartos deste tipo
      obsQuarto: 'Ar Condicionado, TV, Frigobar, WiFi', //detalhes sobre o quarto, o que inclui: tv, ar condicionado
      quarto: [],

    },
    { tipoQuarto: 'Suite Simples',
      CapacidadeQuarto: '2',
      numQuarto: [201, 202, 203, 204, 205, 206, 207],
      obsQuarto: 'Ventilador, Frigobar, WiFi'

    }
    { tipoQuarto: 'Chalé',
      CapacidadeQuarto: '4',
      numQuarto: [16, 18, 21, 22, 23, 30],
      obsQuarto: 'Ventilador, Frigobar, WiFi'

  }
]

  pacotes: string[] = [
    'Pacote Standard', 'Pacote Master', 'Pacote Simples'
  ]


  constructor() { }

  ngOnInit() {
  }

}
