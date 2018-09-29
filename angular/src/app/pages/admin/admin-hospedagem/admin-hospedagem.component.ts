import { Component, OnInit } from '@angular/core';
import { Output, EventEmitter} from '@angular/core';

@Component({
  selector: 'app-admin-hospedagem',
  templateUrl: './admin-hospedagem.component.html',
  styleUrls: ['./admin-hospedagem.component.css']
})
export class AdminHospedagemComponent implements OnInit {

  deleteHotelEmitter = new EventEmitter<string|MaterializeAction>();
  @Output() deleteHotelEmitter = new EventEmitter<any>();

  
  /* deletar hotel */
  onSubmit(deletaHotelForm){
    this.deleteHotelEmitter.emit(nomeHotel);
    this.deleteHotelEmitter.emit({action: 'modal', params: ['close']});  
  }

  deleteHotel(hotel) {
    let i = this.hoteis.findIndex(hoteis => hoteis.nomeHotel  == hotel);
    this.hoteis.splice(i, 1);
  }

  file: File = new File([""], "filename");

  hoteis: any[] = [{
    nomeHotel: 'Ibis', 
    enderecoHotel: 'Av. Beira Mar, 238', 
    descricaoHotel: 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec hendrerit auctor nisi, a cursus elit laoreet eu. Nunc felis ante, lacinia in ante at, feugiat convallis ex. ',
  }];

  hotelFoto: string[] = [
    ''
  ]

  imagem: any = '';


  constructor() { }

  ngOnInit() {
  }

  onSubmit(hotel: any) {
    this.hoteis.push(hotel.value);
    this.hotelFoto.push(this.imagem);

    console.log(this.hotelFoto);

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
} 
