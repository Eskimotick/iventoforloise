import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { AdminAtividadesComponent } from './admin-atividades.component';

describe('AdminAtividadesComponent', () => {
  let component: AdminAtividadesComponent;
  let fixture: ComponentFixture<AdminAtividadesComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ AdminAtividadesComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(AdminAtividadesComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
