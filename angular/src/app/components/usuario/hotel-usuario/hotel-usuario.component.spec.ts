import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { HotelUsuarioComponent } from './hotel-usuario.component';

describe('HotelUsuarioComponent', () => {
  let component: HotelUsuarioComponent;
  let fixture: ComponentFixture<HotelUsuarioComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ HotelUsuarioComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(HotelUsuarioComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
