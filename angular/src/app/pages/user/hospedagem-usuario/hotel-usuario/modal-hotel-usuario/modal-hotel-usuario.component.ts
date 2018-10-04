import { Component, OnInit, Input, Output, EventEmitter  } from '@angular/core';

@Component({
  selector: 'app-modal-hotel-usuario',
  templateUrl: './modal-hotel-usuario.component.html',
  styleUrls: ['./modal-hotel-usuario.component.css']
})
export class ModalHotelUsuarioComponent implements OnInit {

  @Input('hotel') hotel: any;
  @Input ('quarto') quarto: any;
  @Input('hotelFoto') hotelFoto: string;

  quartos: any[] = [
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

    },
    { idHotel: 'h006',
      tipoQuarto: 'Quarto Triplo',
      CapacidadeQuarto: '3',
      numQuarto: [101, 105, 111, 130],
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
