import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { ModalHotelUsuarioComponent } from './modal-hotel-usuario.component';

describe('ModalHotelUsuarioComponent', () => {
  let component: ModalHotelUsuarioComponent;
  let fixture: ComponentFixture<ModalHotelUsuarioComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ ModalHotelUsuarioComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(ModalHotelUsuarioComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
