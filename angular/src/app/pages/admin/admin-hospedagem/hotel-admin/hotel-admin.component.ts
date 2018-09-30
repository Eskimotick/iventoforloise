import { Component, OnInit, Input } from '@angular/core';
import { Output, EventEmitter} from '@angular/core';

@Component({
  selector: 'app-hotel-admin',
  templateUrl: './hotel-admin.component.html',
  styleUrls: ['./hotel-admin.component.css']
})
export class HotelAdminComponent implements OnInit {

  @Input('hotel') hotel: any;
  @Input('hotelFoto') hotelFoto: string;

  @Output() deleteHotelEmitter = new EventEmitter<string>();
  @Output() editHotelEmitter = new EventEmitter<string>();
  @Output() getRoomsEmitter = new EventEmitter<string>();


  pacotes: string[] = [
    'Pacote Standard', 'Pacote Master', 'Pacote Simples'
  ]

  imagem: any = '';

  file: File = new File([""], "filename");

  quartos: any[] = [{
    id: 1,
    idHospedagem: 1,
    tipoQuarto: 'Suite Standard',
    numeroQuartosDisponiveis: 3,
    numeroVagasPorQuarto: 2,
    numerosDosQuartos: [101, 102, 103, 104, []],
    obsQuarto: 'Lorem Ipsum Dolor Sit Amet ...',
    pacotes: '',
  }]


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

  openAddHotel() {
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
  }

}
