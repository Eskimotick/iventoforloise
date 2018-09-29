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
  

  pacotes: string[] = [
    'Pacote Standard', 'Pacote Master', 'Pacote Simples'
  ]
  imagem: any = '';
  file: File = new File([""], "filename");
  quartos: any[] = [{
    nomeQuarto: 'Suite Standard',
    numeroQuarto: 42,
    numeroVagas: 2,
    obsQuartos: 'Lorem Ipsum Dolor Sit Amet ...', 
    pacotes: ''
    
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

  deletaHotel() {
    this.deleteHotelEmitter.emit(this.hotel.nomeHotel);
  }
}
