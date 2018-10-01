import { Component, OnInit } from '@angular/core';


@Component({
  selector: 'app-admin-hospedagem',
  templateUrl: './admin-hospedagem.component.html',
  styleUrls: ['./admin-hospedagem.component.css']
})
export class AdminHospedagemComponent implements OnInit {

  file: File = new File([""], "filename");

  hoteis: any[] = [{
    id: 1,
    nomeHotel: 'Ibis',
    enderecoHotel: 'Av. Beira Mar, 238',
    telefoneHotel: '(21) 2345-6789',
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

  deletaHotel(hotel) {
    let i = this.hoteis.findIndex(ho => ho.id == hotel);
    this.hoteis.splice(i, 1);
  }



}
