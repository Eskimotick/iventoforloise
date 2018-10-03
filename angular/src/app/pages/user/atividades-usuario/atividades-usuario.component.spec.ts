import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { AtividadesUsuarioComponent } from './atividades-usuario.component';

describe('AtividadesUsuarioComponent', () => {
  let component: AtividadesUsuarioComponent;
  let fixture: ComponentFixture<AtividadesUsuarioComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ AtividadesUsuarioComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(AtividadesUsuarioComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
