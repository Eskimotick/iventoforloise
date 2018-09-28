import { Component, OnInit, Input } from '@angular/core';

@Component({
  selector: 'app-hotel-admin',
  templateUrl: './hotel-admin.component.html',
  styleUrls: ['./hotel-admin.component.css']
})
export class HotelAdminComponent implements OnInit {

  @Input('hoteis') hoteis: any;
  @Input('hotelFoto') hotelFoto: string;

  constructor() { }

  ngOnInit() {
  }

}
