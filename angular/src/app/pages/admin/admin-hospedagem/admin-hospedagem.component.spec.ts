import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { AdminHospedagemComponent } from './admin-hospedagem.component';

describe('AdminHospedagemComponent', () => {
  let component: AdminHospedagemComponent;
  let fixture: ComponentFixture<AdminHospedagemComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ AdminHospedagemComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(AdminHospedagemComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
}); 
