import { Component, OnInit, Input } from '@angular/core';
import { Output, EventEmitter} from '@angular/core';

@Component({
  selector: 'app-hotel-admin',
  templateUrl: './hotel-admin.component.html',
  styleUrls: ['./hotel-admin.component.css']
})
export class HotelAdminComponent implements OnInit {

  @Input('hotel') hotel: any;
  @Input('quarto') quarto: any;
  @Input('hotelFoto') hotelFoto: string;

  /*@Output() deleteHotelEmitter = new EventEmitter<string>();
  @Output() editHotelEmitter = new EventEmitter<string>();
  @Output() getRoomsEmitter = new EventEmitter<string>(); */

  quartos: any[] = [
    { idHospedagem: 'h005',
      tipoQuarto: 'Suite Standard',
      CapacidadeQuarto: '2', // ex.: 2 pessoas por quarto
      numQuarto: [102, 103, 104, 105, 106], // numeros dos quartos deste tipo
      obsQuarto: 'Ar Condicionado, TV, Frigobar, WiFi', //detalhes sobre o quarto, o que inclui: tv, ar condicionado
      pacotes: ''
    },
    { idHospedagem: 'h005',
      tipoQuarto: 'Suite Simples',
      CapacidadeQuarto: '2',
      numQuarto: [201, 202, 203, 204, 205, 206, 207],
      obsQuarto: 'Ventilador, Frigobar, WiFi',
      pacotes: ''

    },
    { idHospedagem: 'h006',
      tipoQuarto: 'Chalé',
      CapacidadeQuarto: '4',
      numQuarto: [16, 18, 21, 22, 23, 30],
      obsQuarto: 'Ventilador, Frigobar, WiFi',
      pacotes: ''

    },
    { idHospedagem: 'h006',
      tipoQuarto: 'Quarto Triplo',
      CapacidadeQuarto: '3',
      numQuarto: [101, 105, 111, 130],
      obsQuarto: 'Ventilador, Frigobar, WiFi',
      pacotes: ''

  }
]
  pacotes: string[] = [
    'Pacote Standard', 'Pacote Master', 'Pacote Simples'
  ]

  imagem: any = '';

  file: File = new File([""], "filename");

  /*quartos: any[] = [{
    id: 1,
    idHospedagem: 1,
    tipoQuarto: 'Suite Standard',
    numeroQuartosDisponiveis: 3,
    numeroVagasPorQuarto: 2,
    numerosDosQuartos: [101, 102, 103, 104, []],
    obsQuarto: 'Lorem Ipsum Dolor Sit Amet ...',
    pacotes: '',
  }]*/


  constructor() { }

  ngOnInit() {
  }


  onFileSelection(imagem) {
    let fileList: FileList = imagem.target.files;
      if(fileList.length > 0) {
        this.file = fileList[0];
        this.readThis();
      }

  }

  readThis(){
    let myReader: FileReader = new FileReader();
    myReader.onloadend = (e) => {
      this.imagem = myReader.result;
      console.log(this.imagem);
    }
    myReader.readAsDataURL(this.file);
  }

  /*openAddHotel() {
    this.HotelEmitter.emit(this.hotel.id);
  }

  openDeleteModal() {
    this.deleteHotelEmitter.emit(this.hotel.id);
  }

  openEditModal() {
    this.editHotelEmitter.emit(this.hotel.id);
  }

  openRoomsModal() {
    this.getRoomsEmitter.emit(this.hotel.id);
  }*/

}
